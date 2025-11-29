<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Response</title>
</head>

<body style="background-color: #f8f9fa; font-family: Arial, sans-serif; padding: 20px;">

    <table align="center" cellpadding="0" cellspacing="0" width="600"
        style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <tr>
            <td style="padding: 20px; text-align: center; border-bottom: 1px solid #e9ecef;">
                <h2 style="margin: 0; color: #343a40;">E-Store Response</h2>
                <p style="margin: 5px 0 0; color: #6c757d; font-size: 14px;">We’ve reviewed your message</p>
            </td>
        </tr>

        <!-- User's Message -->
        <tr>
            <td style="padding: 20px;">
                <h3 style="color: #0d6efd; margin-bottom: 10px;">Your Message:</h3>
                <div
                    style="padding: 15px; border: 1px solid #dee2e6; border-radius: 6px; background-color: #ffffff; font-size: 16px; color: #495057;">
                    {{ $userMessage }}
                </div>
            </td>
        </tr>

        <!-- Admin's Response -->
        <tr>
            <td style="padding: 20px;">
                <h3 style="color: #198754; margin-bottom: 10px;">Our Response:</h3>
                <div
                    style="padding: 15px; border: 1px solid #198754; border-radius: 6px; background-color: #e9f7ef; font-size: 16px; color: #212529; font-weight: bold;">
                    {{ $adminResponse }}
                </div>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding: 20px; font-size: 14px; color: #6c757d;">
                Regards,<br>
                <strong style="color: #343a40;">E-Store Team</strong>
            </td>
        </tr>

        <tr>
            <td
                style="background-color: #f8f9fa; text-align: center; font-size: 12px; color: #6c757d; padding: 10px; border-top: 1px solid #e9ecef;">
                © {{ date('Y') }} E-Store. All rights reserved.
            </td>
        </tr>
    </table>

</body>

</html>
