<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="https://getbootstrap.com/docs/4.0/assets/img/favicons/favicon.ico">

        <title>Vax Pass QR Generator</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://getbootstrap.com/docs/4.0/examples/starter-template/starter-template.css" rel="stylesheet">
    </head>

    <body>

        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
          <a class="navbar-brand" href="/vaxpass/generate">Vax Pass</a>
        </nav>

        <main role="main" class="container">

            <div class="row">
                <div class="col-sm-6">
                <?php
                // Display QR code
                if (! empty($_GET['data'])) {
                    require __DIR__ . '/../phpqrcode/lib/full/qrlib.php';
                    echo QRcode::svg($_GET['data']); // QR code
                    echo '<br />';
                    echo '<p><strong>' . Basic::decrypt( base64_decode($_GET['data']), PASS_PHRASE, 'vaxv1' ) . '</strong></p>'; // Decrypted QR data
                    exit;
                }

                // Generate and email QR code
                if (isset($_POST['generate'])) {
                    $email = $_POST['email'];
                    $name = htmlspecialchars($_POST['name']);
                    $dose = htmlspecialchars($_POST['dose']);
                    $date = htmlspecialchars($_POST['date']);
                    $location = htmlspecialchars($_POST['location']);
                    $plaintext = $name . ' completed the ' . $dose . ' of the COVID-19 vaccine on ' . $date . ' at ' . $location . '.';

                    $encrypted = Basic::encrypt($plaintext, PASS_PHRASE, 'vaxv1');
                    $data = base64_encode($encrypted);
                    $link = BASE_URL . 'generate?data=' . $data;

                    /* Place script here to call mail API to sent link to QR code. */

                    header('Location: ' . $link); // Display QR code
                    exit;
                }
                ?>
                <h2>Vaccination Information</h2>
                <form class="form-horizontal" method="post">
                <label for="name">Name</label>
                <input class="form-control" type="text" placeholder="Name" aria-label="Name" name="name" required><br />
                <label for="dose">Dose</label>
                <select class="form-control" name="dose" required>
                <option></option>
                <option>First Dose</option>
                <option>Last Dose</option>
                </select><br />
                <label for="date">Date</label>
                <input class="form-control" type="date" placeholder="Date" aria-label="Date" name="date" required><br />
                <label for="location">Location</label>
                <input class="form-control" type="text" placeholder="Location" aria-label="Location" name="location" value="Vaccine Site Alpha Bravo" readonly><br />
                <label for="email">Email</label>
                <input class="form-control" type="email" placeholder="Email" aria-label="Email" name="email" required><br />
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="generate">Generate</button>
                </form>
                </div>
            </div>

        </main>
  
    </body>
</html>