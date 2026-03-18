<x-mail::message>
# Congratulations, {{ $application->user->name ?? $application->first_name }}!

We are thrilled to inform you that you have been successfully selected for admission to the **{{ $application->course->name ?? 'Course' }}** program for the upcoming academic session.

Your application (ID: **{{ $application->application_no }}**) has successfully passed the verification and merit generation stages.

Please proceed to your student dashboard to accept the offer and complete your fee payment to secure your seat.

<x-mail::button :url="route('student.login')">
Proceed to Student Portal
</x-mail::button>

If you have any questions, please contact our helpdesk.

Thanks,<br>
Admissions Team, {{ config('app.name') }}
</x-mail::message>
