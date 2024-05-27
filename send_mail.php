<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Veuillez remplir correctement le formulaire.";
        exit;
    }

    $recipient = "aleksander@nisima.fr";

    $email_subject = "Nouveau message de $name: $subject";

    $email_content = "Nom: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    $email_headers = "From: $name <$email>";

    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Merci! Votre message a été envoyé.";
    } else {
        http_response_code(500);
        echo "Oups! Quelque chose a mal tourné et nous n'avons pas pu envoyer votre message.";
    }

} else {
    http_response_code(403);
    echo "Il y a eu un problème avec votre soumission, veuillez réessayer.";
}
?>
