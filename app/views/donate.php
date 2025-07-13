<h2>Doação via PayPal</h2>
<p>Ao doar, você recebe recompensas in-game automaticamente após o pagamento.</p>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_donations">
    <input type="hidden" name="business" value="SEU_EMAIL_PAYPAL_AQUI">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="item_name" value="Doação para L2 Origens">
    <input type="hidden" name="return" value="http://localhost/donate/retorno">

    <label>Valor (USD):</label><br>
    <input type="number" name="amount" min="1" step="1"><br><br>

    <button type="submit">Doar com PayPal</button>
</form>
