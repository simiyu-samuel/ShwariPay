{*
 * Shwaripay - Lipa Na M-Pesa Module for Prestashop 1.7
 *
 * Enhanced form for payment step with improved styling and user experience.
 *
 * @author Samuel Simiyu <samueldevke@gmail.com>
 * @license https://opensource.org/licenses/afl-3.0.php
 *}

<form action="{$action}" id="payment-form" method="post" style="max-width: 500px; margin: auto; background: #f9f9f9; padding: 5px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
    <p style="font-size: 12px; color: #555; text-align: justify;">
        {l s='Please enter your M-PESA Number. Shortly,
         you will receive an M-PESA prompt on your phone requesting 
         you to enter your M-PESA PIN to complete your payment. Ensure 
         your phone is ON and UNLOCKED to enable you to complete the process.
          Thank you.' mod='shwaripay'}
    </p>

    <div style="margin-top: 15px;">
        <label for="phone_number" style="font-weight: bold; color: #444;">{l s='Enter M-PESA Phone No.'}</label>
        <input type="tel" name="phone_number" id="phone_number" 
               placeholder="07XXXXXXXX" 
               style="width: 100%; padding: 10px; margin-top: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;" 
               required>
        <small style="color: #888; font-size: 12px; margin-top: 5px; display: block;">
            {l s='Format: 07XXXXXXXX (10 digits)' mod='shwaripay'}
        </small>
    </div>

    <button type="submit" class="btn btn-success" 
            style="width: 100%; padding: 10px; margin-top: 20px; background: #28a745; color: #fff; font-weight: bold; border: none; border-radius: 4px; cursor: pointer; transition: background 0.3s;">
        {l s='PAY WITH MPESA' mod='shwaripay'}
    </button>

    <p style="text-align: center; margin-top: 15px; font-size: 12px; color: #888;">
        {l s='Your transaction is secure and encrypted.' mod='shwaripay'}
    </p>
</form>
