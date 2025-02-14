@extends('website.main.app')
@section('title','Terms & Conditions')
@section('website.content')
<div style="background: #fff; padding: 50px; border-radius: 10px; max-width: 850px; margin: auto; box-shadow: 0 8px 16px rgba(0,0,0,0.15);" class="mb-5">

    <h1 style="color: #222; text-align: center; font-size: 32px; margin-bottom: 30px;">Terms & Conditions</h1>

    <p style="font-size: 16px; line-height: 1.8;">Welcome to <strong>Vivace Collections</strong>. By using our website, you agree to comply with and be bound by the following terms and conditions. Please review them carefully.</p>

    <h2 style="color: #555; font-size: 22px; margin-top: 30px;">1. Use of the Website</h2>
    <ul style="padding-left: 25px; font-size: 16px; line-height: 1.8;">
        <li>You must be at least 18 years old or have parental consent to use our website.</li>
        <li>You are responsible for maintaining the confidentiality of your account and password.</li>
        <li>Unauthorized use of the website may result in legal action.</li>
        <li>"This website is owned and managed by KASSH AND BRANDS".</li>

    </ul>

    <h2 style="color: #555; font-size: 22px; margin-top: 30px;">2. Products & Services</h2>
    <ul style="padding-left: 25px; font-size: 16px; line-height: 1.8;">
        <li>All products are subject to availability and may be discontinued at any time.</li>
        <li>We strive to ensure product descriptions are accurate, but errors may occur.</li>
        <li>We reserve the right to limit the sale of products to any person or region.</li>
    </ul>

    <h2 style="color: #555; font-size: 22px; margin-top: 30px;">3. Pricing & Payments</h2>
    <ul style="padding-left: 25px; font-size: 16px; line-height: 1.8;">
        <li>All prices are listed in INR and are subject to change without notice.</li>
        <li>We accept various payment methods through trusted third-party services.</li>
        <li>If your payment is declined, we are not responsible for delays or order cancellations.</li>
    </ul>

    <h2 style="color: #555; font-size: 22px; margin-top: 30px;">4. Shipping & Delivery</h2>
    <ul style="padding-left: 25px; font-size: 16px; line-height: 1.8;">
        <li>Delivery times are estimates and may vary due to external factors.</li>
        <li>We are not responsible for delays caused by courier services.</li>
        <li>Incorrect delivery details provided by the customer may result in delivery issues.</li>
    </ul>

    <h2 style="color: #555; font-size: 22px; margin-top: 30px;">5. Return & Refund Policy</h2>
    <p style="font-size: 16px; line-height: 1.8;">Please refer to our <a href="{{ route('refund') }}" style="color: #007bff; text-decoration: none;">Return & Refund Policy</a> for detailed information on returns and refunds.</p>

    <h2 style="color: #555; font-size: 22px; margin-top: 30px;">6. Intellectual Property</h2>
    <ul style="padding-left: 25px; font-size: 16px; line-height: 1.8;">
        <li>All content on this website, including text, graphics, and logos, is our intellectual property.</li>
        <li>Unauthorized use or reproduction of our content is prohibited.</li>
    </ul>

    <h2 style="color: #555; font-size: 22px; margin-top: 30px;">7. Limitation of Liability</h2>
    <p style="font-size: 16px; line-height: 1.8;">We are not liable for any direct, indirect, or consequential damages arising from your use of our website, products, or services.</p>

    <h2 style="color: #555; font-size: 22px; margin-top: 30px;">8. Changes to Terms</h2>
    <p style="font-size: 16px; line-height: 1.8;">We reserve the right to modify these Terms & Conditions at any time. Significant changes will be communicated on our website.</p>

    <h2 style="color: #555; font-size: 22px; margin-top: 30px;">9. Governing Law</h2>
    <p style="font-size: 16px; line-height: 1.8;">These terms are governed by and construed according to the laws of India. Any disputes will be resolved in Indian courts.</p>

    <h2 style="color: #555; font-size: 22px; margin-top: 30px;">10. Contact Us</h2>
    <p style="font-size: 16px; line-height: 1.8;">If you have any questions about these Terms & Conditions, please contact us at: <a href="mailto:support@vivacecollections.com" style="color: #007bff; text-decoration: none;">support@vivacecollections.com</a></p>

    <p style="text-align: center; font-size: 18px; margin-top: 50px; color: #444;">Thank you for choosing <strong>Vivace Collections</strong>!</p>

</div>
@endsection
