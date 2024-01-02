<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Invite;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Browsershot\Browsershot;

class UserController extends Controller
{
    public function show(User $user): View
    {
        return view('dealer.employee.show', [
            'user' => $user,
        ]);
    }

    public function create(Invite $invite): View
    {
        return view('dealer.employee.register', [
            'invite' => $invite,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $invite = Invite::where('id', $request['id'])->first();

        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Create user
        $user = User::create([
            'name' => $invite['name'],
            'email' => $invite['email'],
            'phone' => $request->input('phone'),
            'department_id' => $invite['department_id'],
            'password' => bcrypt($request->input('password')),
        ]);

        if ($invite['courses']) {
            foreach ($invite['courses'] as $key => $course) {
                CourseResults::create([
                    'user_id' => $user->id,
                    'course_id' => $key,
                    'percentage' => 100,
                    'passed' => 1,
                    'created_at' => $course.' '.now()->format('H:i:s'),
                    'updated_at' => $course.' '.now()->format('H:i:s'),
                ]);

                $dotCompletion = Course::where('id', $key)->where('slug', 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding')->first() ?? null;

                if ($dotCompletion) {
                    $html = view('dealer.course.CertDownloadView', [
                        'user' => User::where('id', $user->id)->first(),
                        'store' => $request->get('store')?->name ?? tenant('name'),
                        'passed_on' => Carbon::parse($course)->format('F d, Y'),
                    ])->render();

                    $pdf = Browsershot::html($html)->landscape()->pdf();

                    $fileName = Str::slug($user->name).'-'.now()->format('m-d-Y').'-dot-certificate.pdf';

                    Storage::disk('local')->put($fileName, $pdf);

                    $localFile = Storage::disk('local')->get($fileName);

                    Storage::disk('armp-certs')->put(tenant('id').'/'.$user->id.'/'.$fileName, $localFile);

                    Storage::delete($fileName);

                    Certificate::create([
                        'user_id' => $user->id,
                        'course_name' => 'DOT Hazardous Materials Transportation',
                        'file_name' => $fileName,
                    ]);
                }
            }
        }

        foreach ($invite['stores'] as $store) {
            $user->stores()->attach($store);
        }

        $user->assignRole($invite['roles']);

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $invite->delete();

        event(new Registered($user));

        $user->markEmailAsVerified();

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
