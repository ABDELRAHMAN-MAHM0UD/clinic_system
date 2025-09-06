@component('mail::message')
# Appointment Confirmation

Dear {{ $patientName }},

Thank you for booking an appointment with {{ config('app.name') }}. Your appointment has been successfully confirmed.

@component('mail::panel')
## Appointment Details
**Doctor:** Dr. {{ $doctorName }}  
**Date:** {{ $date }}  
**Time:** {{ $time }}  
@endcomponent

## Important Instructions
1. Please arrive **15 minutes** before your scheduled appointment
2. Bring with you:
   - Valid identification
   - Insurance card (if applicable)
   - List of current medications
   - Any relevant medical records

## Cancellation Policy
If you need to cancel or reschedule your appointment, please notify us at least 24 hours in advance to avoid any cancellation fees.

@component('mail::button', ['url' => $url, 'color' => 'primary'])
View Your Appointment
@endcomponent

## Contact Us
If you have any questions or need assistance, please don't hesitate to contact us:
- **Phone:** [Clinic Phone Number]
- **Email:** [Clinic Email]

Thank you for choosing {{ config('app.name') }}. We look forward to providing you with excellent care.

Best regards,  
The {{ config('app.name') }} Medical Team
@endcomponent
