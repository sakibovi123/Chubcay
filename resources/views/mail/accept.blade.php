{{-- {{ $message }} --}}
{{-- <p>Thank you for registering</p><br>
<p>Please now pay ${{ $fee }}.00</p><br>
<a href="">Pay Now</a> --}}

<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;">
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="https://ibb.co/GtWmbWK" alt="Company Logo" style="max-width: 150px;">
    </div>
    <h2 style="color: #333; text-align: center;">Thank You for Registering!</h2>
    <p style="color: #555; font-size: 16px; line-height: 1.6;">
        Hi {{ $user->first_name }},
    </p>
    @if($stat == 'manual')
        <p style="color: #555; font-size: 16px; line-height: 1.6;">
            We're excited to have you on board. Your payment has been paid successfully.
        </p>
        <p style="color: #777; font-size: 12px; text-align: center; margin-top: 20px;">
            &copy; 2024 Chubcay. All rights reserved.
        </p>
    @else
        <p style="color: #555; font-size: 16px; line-height: 1.6;">
            We're excited to have you on board. To complete your registration, please proceed with the payment.
        </p>
        <div style="text-align: center; margin: 30px 0;">
            <p style="color: #333; font-size: 18px;">
                Your payment amount: <strong>${{ $fee }}.00</strong>
            </p>
        </div>
        <div style="text-align: center;">
            <a href="{{ $link }}" style="background-color: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">Pay Now</a>
        </div>
        <p style="color: #777; font-size: 14px; text-align: center; margin-top: 30px;">
            If you have any questions, feel free to <a href="https://members.chubcay-stage.online/#contact" style="color: #007bff; text-decoration: none;">contact us</a>.
        </p>
        <p style="color: #777; font-size: 12px; text-align: center; margin-top: 20px;">
            &copy; 2024 Chubcay. All rights reserved.
        </p>

    @endif

</div>
