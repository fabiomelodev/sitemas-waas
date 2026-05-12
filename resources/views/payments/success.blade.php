<div class="payment-success-container">
    <h1>Payment Confirmed!</h1>
    <p>Check your email (<strong>{{ auth()->user()->email ?? 'the one used for purchase' }}</strong>) to set your
        password and access your dashboard.</p>

    <div class="instructions-box">
        <ol>
            <li>Find the email with the subject: "Set your password".</li>
            <li>Click the activation button.</li>
            <li>You will be automatically logged into your client panel.</li>
        </ol>
    </div>
</div>