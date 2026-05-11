<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos identifiants de connexion</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family: 'Segoe UI', Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%;">
                    <tr>
                        <td align="center" style="background-color:#1a56db; border-radius:12px 12px 0 0; padding: 40px 48px;">
                            <p style="margin:0; font-size:28px; font-weight:700; color:#ffffff; letter-spacing:-0.5px;">
                                AppDevise
                            </p>
                            <p style="margin:10px 0 0; font-size:14px; color:#a5b4fc; letter-spacing:1px; text-transform:uppercase;">
                                Gestion de devises en toute simplicité
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#ffffff; padding: 48px;">

                            <p style="margin:0 0 8px; font-size:22px; font-weight:700; color:#111827;">
                                Bienvenue, {{ $name }} 
                            </p>
                            <p style="margin:0 0 32px; font-size:15px; color:#6b7280; line-height:1.6;">
                                Votre compte a été créé avec succès. Retrouvez ci-dessous vos identifiants pour vous connecter à la plateforme.
                            </p>

                          
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; margin-bottom:32px;">
                                <tr>
                                    <td style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
                                        <p style="margin:0 0 4px; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.8px;">Adresse e-mail</p>
                                        <p style="margin:0; font-size:15px; font-weight:600; color:#111827;">{{ $email }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 24px;">
                                        <p style="margin:0 0 4px; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.8px;">Mot de passe temporaire</p>
                                        <p style="margin:0; font-size:18px; font-weight:700; color:#1a56db; font-family: 'Courier New', monospace; letter-spacing:2px;">{{ $password }}</p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Warning --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fffbeb; border-left:4px solid #f59e0b; border-radius:0 6px 6px 0; margin-bottom:32px;">
                                <tr>
                                    <td style="padding: 14px 18px;">
                                        <p style="margin:0; font-size:13px; color:#92400e; line-height:1.5;">
                                             &nbsp;Pour votre sécurité, veuillez changer votre mot de passe dès votre première connexion.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td style="background-color:#f8fafc; border-top:1px solid #e2e8f0; border-radius:0 0 12px 12px; padding: 24px 48px;" align="center">
                            <p style="margin:0; font-size:12px; color:#9ca3af; line-height:1.6;">
                                Cet e-mail a été envoyé automatiquement par <strong>AppDevise</strong>.<br>
                                Si vous n'êtes pas à l'origine de cette demande, veuillez ignorer ce message.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
