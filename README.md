# ShwariPay - Lipa na M-Pesa Module for PrestaShop

ShwariPay enables seamless mobile payment integration for Kenyan merchants using M-Pesa's STK Push. It allows customers to pay directly from their mobile phones during checkout, enhancing convenience and boosting conversions.

## 🛠️ Features

- STK Push integration (Lipa na M-Pesa)
- Admin configuration panel
- Secure API authentication (Access Token)
- Customer payment confirmation redirection
- Callback support for payment status
- Compatible with PrestaShop 1.7+

---

## 📦 Installation

1. **Download** the `shwaripay.zip` or clone the module into your `modules/` directory.
2. **Log into your PrestaShop Admin Panel**.
3. Navigate to `Modules > Module Manager`.
4. Click `Upload a module` and upload the `shwaripay.zip`.
5. Install the module once it appears.

---

## ⚙️ Configuration

After installation:

1. Navigate to `Modules > Module Manager > ShwariPay > Configure`.
2. Fill in the required M-Pesa credentials:

   - **Business Shortcode**: Your Paybill or Till Number
   - **Consumer Key**: From Safaricom Developer Portal
   - **Consumer Secret**: From Safaricom Developer Portal
   - **Passkey**: Your Lipa na M-Pesa passkey
   - **Mode**: Choose Sandbox or Live

3. Save your configuration.

---

## 🚀 How It Works

1. At checkout, customers enter their **M-Pesa phone number**.
2. Upon clicking pay, an **STK push** is sent to their phone.
3. Customer enters M-Pesa PIN and confirms payment.
4. The module processes the response and redirects appropriately.

---

## 📞 Support

For assistance or feedback, please contact [samueldevke@gmail.com] Or Whatsapp: 0796590401.

---

## 🔐 Disclaimer

Ensure your credentials are secure. This module uses HTTPS and proper access token handling, but your server must also be secure. Also get correct credentials from yor MPESA portal And Daraja API portal.
