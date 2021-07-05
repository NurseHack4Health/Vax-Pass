<!DOCTYPE html>
<html>
	<head>
		<title>Vax Pass Code Scanner</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="https://getbootstrap.com/docs/4.0/assets/img/favicons/favicon.ico">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	</head>

	<body>

		<div class="container">
			<h2>Vax Pass QR Code Scanner</h2>
			<div id="reader" width="600px" height="600px"></div>
			<div id="result" style="display: none;"></div>
			<br />
			<form id="form" style="display: none;" onsubmit="event.preventDefault()" method="post">
				<div class="form-group">
					<label for="qr-input-value">QR Code Data: </label>
					<input type="text" class="form-control" id="qr-input-value" name="qr-input-value" readonly />
				</div>
				<button type="reset" class="btn btn-primary" onclick="resetForm()">Scan</button>
			</form>
		</div>

		<script type="text/javascript" src="html5-qrcode/html5-qrcode.min.js"></script>
		<script>
			const scanner = document.getElementById('reader');
			const qrInput = document.getElementById('qr-input-value');
			const result = document.getElementById('result');
			const form = document.getElementById('form');

			function onScanSuccess(qrMsg) {
				qrInput.value = qrMsg;
				scanner.style.display = 'none';
				result.style.display = 'block';
				form.style.display = 'block';

				fetch('<?= BASE_URL . 'verify' ?>', {
					method: 'POST',
					body: qrMsg
				})
				.then((res) => {
					if (res.status == 200) {
						return res.text();
					} else {
						return 'Error: Invalid QR Code.';
					}
				})
				.then((data) => {
					result.innerHTML = '<br />Certificate Verification Result:<br /><strong>' + data + '</strong>';
				});
			}

			function onScanFailure(error) {
				console.warn(`QR error = ${error}`);
			}

			let html5QrcodeScanner = new Html5QrcodeScanner(
				'reader', { fps: 20, qrbox: 300 }, false);
			html5QrcodeScanner.render(onScanSuccess, onScanFailure);

			function resetForm() {
				scanner.style.display = 'block';
				result.style.display = 'none';
				result.textContent = '';
				form.style.display = 'none';
			}
		</script>

	</body>
</html>