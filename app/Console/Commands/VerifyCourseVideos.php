<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\Dealer\Course as DealerCourse;
use App\Services\VimeoService;
use Illuminate\Console\Command;

class VerifyCourseVideos extends Command
{
    protected $signature = 'courses:verify-videos {--fix : Attempt to fix issues by refreshing video data}';
    protected $description = 'Verify all course videos are accessible and properly configured';
    protected VimeoService $vimeoService;

    public function handle(): int
    {
        $this->vimeoService = new VimeoService();

        $this->info('Verifying course videos...');
        $this->newLine();

        // Get all courses with video IDs
        $centralCourses = Course::query()->whereNotNull('video_id')->get();
        $dealerCourses = DealerCourse::whereNotNull('video_id')->get();

        $allCourses = $centralCourses->merge($dealerCourses);

        if ($allCourses->isEmpty()) {
            $this->warn('No courses with videos found.');

            return self::SUCCESS;
        }

        $this->info("Found {$allCourses->count()} courses with videos");
        $this->newLine();

        $issues = [];
        $fixed = 0;

        $progressBar = $this->output->createProgressBar($allCourses->count());
        $progressBar->start();

        foreach ($allCourses as $course) {
            $result = $this->verifyCourse($course);

            if ($result['has_issues']) {
                $issues[] = $result;
            }

            if ($result['fixed'] ?? false) {
                $fixed++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Summary
        $this->displaySummary($allCourses->count(), count($issues), $fixed);

        // Display issues
        if ($issues !== []) {
            $this->displayIssues($issues);
        }

        return $issues === [] ? self::SUCCESS : self::FAILURE;
    }

    protected function verifyCourse($course): array
    {
        $videoId = $course->video_id;
        $courseName = $course->name ?? $course->slug;
        $courseType = $course instanceof DealerCourse ? 'Dealer' : 'Central';

        $result = [
            'course_name' => $courseName,
            'course_type' => $courseType,
            'video_id' => $videoId,
            'has_issues' => false,
            'issues' => [],
            'fixed' => false,
        ];

        // Get video data
        $videoData = $this->vimeoService->getVideo($videoId);

        if (! $videoData) {
            $result['has_issues'] = true;
            $result['issues'][] = 'Failed to fetch video data from Vimeo API';

            return $result;
        }

        // Check video status
        if (isset($videoData['status']) && $videoData['status'] !== 'available') {
            $result['has_issues'] = true;
            $result['issues'][] = "Video status: {$videoData['status']} (expected: available)";
        }

        // Get privacy settings
        $privacyData = $this->vimeoService->getVideoPrivacySettings($videoId);

        if ($privacyData) {
            // Check if video is playable
            if (! ($privacyData['is_playable'] ?? false)) {
                $result['has_issues'] = true;
                $result['issues'][] = 'Video is not playable';
            }

            // Check privacy settings
            if (($privacyData['privacy_view'] ?? '') === 'disable') {
                $result['has_issues'] = true;
                $result['issues'][] = 'Video viewing is disabled';
            }

            if (($privacyData['privacy_embed'] ?? '') === 'private') {
                $result['has_issues'] = true;
                $result['issues'][] = 'Video embedding is set to private';
            }

            // Check domain whitelist
            $embedDomains = $privacyData['embed_domains'] ?? [];
            if (! empty($embedDomains)) {
                $hasAllowedDomain = false;
                foreach ($embedDomains as $domain) {
                    if (str_contains((string) $domain, 'armp.app') || str_contains((string) $domain, '*')) {
                        $hasAllowedDomain = true;
                        break;
                    }
                }

                if (! $hasAllowedDomain) {
                    $result['has_issues'] = true;
                    $result['issues'][] = 'Domain whitelist does not include *.armp.app. Allowed: '.implode(', ', $embedDomains);
                }
            }

            // Check if password protected
            if ($privacyData['password'] ?? false) {
                $result['has_issues'] = true;
                $result['issues'][] = 'Video is password protected';
            }
        }

        return $result;
    }

    protected function displaySummary(int $total, int $issues, int $fixed): void
    {
        $this->info('Verification Complete!');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Videos', $total],
                ['Videos with Issues', $issues],
                ['Videos OK', $total - $issues],
            ]
        );
    }

    protected function displayIssues(array $issues): void
    {
        $this->newLine();
        $this->error('Found '.count($issues).' videos with issues:');
        $this->newLine();

        foreach ($issues as $issue) {
            $this->warn("Course: {$issue['course_name']} ({$issue['course_type']})");
            $this->line("  Video ID: {$issue['video_id']}");

            foreach ($issue['issues'] as $issueText) {
                $this->line("  • {$issueText}");
            }

            $this->newLine();
        }

        $this->newLine();
        $this->comment('To fix privacy settings, visit: https://vimeo.com/manage/videos');
        $this->comment('Ensure videos are set to:');
        $this->comment('  - Privacy: Anyone (or Unlisted with domain whitelist)');
        $this->comment('  - Embed: Public');
        $this->comment('  - Domain whitelist: Include *.armp.app');
    }
}
