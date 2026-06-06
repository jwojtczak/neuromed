<?php
// Konfiguracja
$to = "j.wojtczak20@gmail.com";  // ← Podaj tutaj swój adres e-mail
$subject = "Wiadomość z formularza kontaktowego NEURO-MED";

// Zabezpieczenie przed pustymi polami
if (
    empty($_POST['name']) ||
    empty($_POST['email']) ||
    empty($_POST['message']) ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
) {
    http_response_code(400);
    echo "Nieprawidłowe dane w formularzu. Uzupełnij wszystkie pola.";
    exit;
}

// Pobieranie danych
$name = strip_tags(trim($_POST['name']));
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars(trim($_POST['message']));

// Tworzenie treści e-maila
$email_content = "Imię i nazwisko: $name\n";
$email_content .= "E-mail: $email\n\n";
$email_content .= "Wiadomość:\n$message\n";

// Nagłówki
$headers = "From: $name <$email>";

// Wysyłka
if (mail($to, $subject, $email_content, $headers)) {
    http_response_code(200);
    echo "Dziękujemy! Wiadomość została wysłana.";
} else {
    http_response_code(500);
    echo "Wystąpił błąd serwera. Spróbuj ponownie później.";
}
?>
