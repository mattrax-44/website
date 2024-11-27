<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="We have a wide collection of car parts">
    <meta name="keywords" content="engine, parts, panels">
    <link rel="stylesheet" href="styles.css">
    <title>Contact Us</title>
</head>

<body>
    <?php include "nav.php"; ?>

    <main>
        <h1>Contact Us</h1>

        <section class="contact-details">
            <h2>Reach Out to Us</h2>
            <p><strong>Telephone:</strong> <a href="tel:+21249200">21249200</a></p>
            <p><strong>Email:</strong> <a href="mailto:debson@gmail.com">debson@gmail.com</a></p>
            <p><strong>WhatsApp:</strong> <a href="https://wa.me/99994021" target="_blank">99994021</a></p>
        </section>

        <section class="contact-form">
            <h2>Send Us a Message</h2>
            <form action="process_contact.php" method="POST">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Your Email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" placeholder="Your Message" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </section>
    </main>

    <?php include "footer.php"; ?>

    <script src="javascript/script.js"></script>
</body>

</html>
