<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Queries;

use App\Domain\Tenant\Course\Data\UserCourseListItem;
use App\Models\Dealer\Course;
use App\Models\User;
use App\Services\UserCourseService;
use Illuminate\Support\Collection;

class GetUserCourseList
{
    /**
     * DOT hazardous-materials modules. Module N is locked until module N-1 is passed.
     * Order matters — keys are 1-indexed.
     *
     * @var array<int, string>
     */
    private const array MODULE_SLUGS = [
        1 => 'dot-hazardous-materials-transportation',
        2 => 'dot-hazardous-materials-transportation-identifying-hazardous-materials',
        3 => 'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment',
        4 => 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding',
    ];

    public function __construct(private readonly UserCourseService $courseService) {}

    /**
     * @return Collection<int, UserCourseListItem>
     */
    public function handle(User $user): Collection
    {
        $courseIds = $this->courseService->getCourseIds($user);

        if ($courseIds === []) {
            return collect();
        }

        $courses = Course::query()
            ->whereIn('id', $courseIds)
            ->withLastResult($user->id)
            ->orderBy('name')
            ->get();

        $passedModuleSlugs = $this->passedModuleSlugs($courses);

        return $courses->map(function (Course $course) use ($passedModuleSlugs): UserCourseListItem {
            $moduleIndex = array_search($course->slug, self::MODULE_SLUGS, true);
            $moduleIndex = $moduleIndex === false ? null : $moduleIndex;

            return UserCourseListItem::fromCourse(
                course: $course,
                latest: $course->lastResult,
                isLocked: $this->isLocked($moduleIndex, $passedModuleSlugs),
                moduleIndex: $moduleIndex,
            );
        });
    }

    /**
     * @param  Collection<int, Course>  $courses
     * @return array<string, bool>
     */
    private function passedModuleSlugs(Collection $courses): array
    {
        $bySlug = $courses->keyBy('slug');
        $passed = [];

        foreach (self::MODULE_SLUGS as $slug) {
            $course = $bySlug->get($slug);
            $passed[$slug] = $course?->lastResult?->passed === true;
        }

        return $passed;
    }

    /**
     * @param  array<string, bool>  $passedModuleSlugs
     */
    private function isLocked(?int $moduleIndex, array $passedModuleSlugs): bool
    {
        if ($moduleIndex === null || $moduleIndex === 1) {
            return false;
        }

        for ($i = 1; $i < $moduleIndex; $i++) {
            if (! ($passedModuleSlugs[self::MODULE_SLUGS[$i]] ?? false)) {
                return true;
            }
        }

        return false;
    }
}
