<!DOCTYPE html>
<html>

<body>
<h1>Richiesta di reimpostazione della
password</h1>
<p>Ciao {{$user->name}}</p>
<p>Qualcuno ha richiesto una nuova password per l'account seguente su II <br>Mediano:</p>
<p>Nome utente: {{$user->name}}</p>
<p>Se non hai effettuato questa richiesta, ignora la presente email. Se desideri
procedere:</p>
<a href="{{url('forgot-link/'.$user->id)}}">Fai clic qui per reimpostare la tua password</a>
<p>Grazie per la lettura.</p>
</body>
</html>