# 🧪 MFA LOGIN - QUICK TEST GUIDE

## ✅ LIVE TESTING (5 Minutes)

### Prerequisites
- Laravel server running: `php artisan serve`
- Browser open: `http://localhost:8000`
- Email system configured (MAIL_DRIVER in .env)

---

## 🎬 Test Scenario 1: Successful MFA Login

### Steps:
1. **Go to Login Page**
   ```
   URL: http://localhost:8000/login
   ```

2. **Enter Credentials**
   ```
   Email/Username: admin@mail.com
   Password: password
   ```
   (Or use your test user credentials)

3. **Click Login**
   - Should see: "Kode verifikasi telah dikirimkan ke email Anda."
   - Should redirect to: `/login/verify-pin`

4. **Check Email**
   - Check inbox for email from system
   - Copy 4-digit PIN
   - Example PIN: `5678`

5. **Enter PIN**
   - Paste PIN in form
   - Should have 4 digits only
   - Form shows placeholder: `0000`

6. **Click Verify**
   - Should redirect to home page
   - Should see: "Login berhasil!"
   - Should be authenticated (username appears in navbar)

### Expected Result: ✅ SUCCESS
```
Before:  Not logged in → /login
After:   Logged in → /home
```

---

## 🎬 Test Scenario 2: Wrong PIN

### Steps:
1. Login with credentials (same as above)
2. Get redirected to PIN form
3. Check email for correct PIN
4. **Intentionally enter wrong PIN**
   ```
   Correct PIN: 5678
   Enter:       1234
   ```
5. Click Verify

### Expected Result: ⚠️ ERROR
```
Error Message: "Kode verifikasi salah atau sudah kadaluarsa."
Can retry: YES
Attempts remaining: 4 out of 5
```

---

## 🎬 Test Scenario 3: PIN Expiry

### Steps:
1. Login with credentials
2. **Wait 10+ minutes** (PIN TTL is 10 minutes)
3. Check email for old PIN
4. Enter old PIN
5. Click Verify

### Expected Result: ❌ EXPIRED
```
Error Message: "Kode verifikasi salah atau sudah kadaluarsa."
Status: PIN expired
Action: Must login again to get new PIN
```

---

## 🎬 Test Scenario 4: Max Attempts Exceeded

### Steps:
1. Login with credentials
2. Check email for PIN
3. **Enter wrong PIN 5 times**
   ```
   Attempt 1: 1111 → Error (4 remaining)
   Attempt 2: 2222 → Error (3 remaining)
   Attempt 3: 3333 → Error (2 remaining)
   Attempt 4: 4444 → Error (1 remaining)
   Attempt 5: 5555 → Error (0 remaining)
   ```
4. On 6th attempt

### Expected Result: 🔒 LOCKED
```
Status: PIN locked
Action: Must login again
Note: Verification code is consumed/invalid
```

---

## 🎬 Test Scenario 5: Session Timeout

### Steps:
1. Login with credentials
2. **Close browser** (or clear session)
3. Try to access `/login/verify-pin` directly
4. Try to submit PIN form

### Expected Result: 🚫 SESSION INVALID
```
Error Message: "Session expired. Please login again."
Redirect to: /login
Action: Must login from beginning
```

---

## 📧 Email Verification

### Where to Check Email?
- **Development:** Use local email service or test mail (Mailtrap, Mailgun)
- **Testing:** Use `MAIL_DRIVER=log` to see emails in `storage/logs/`

### Check Email in Logs:
```bash
# Terminal
tail -f storage/logs/laravel.log | grep -i mail

# Or view file
cat storage/logs/laravel.log | grep "To:" | tail -1
```

### Email Content Should Include:
```
To: user@email.com
Subject: Kode Verifikasi Login
Body: 
  - Kode 4 digit (e.g., 5678)
  - Pesan "Kode berlaku 10 menit"
  - Security notice
```

---

## 🔧 Debugging

### Check Database:
```sql
-- View latest verification codes
SELECT * FROM verification_codes 
WHERE type = 'login_mfa' 
ORDER BY created_at DESC 
LIMIT 5;

-- Check PIN details
SELECT id, email, type, attempts, expires_at, consumed_at 
FROM verification_codes 
WHERE email = 'user@email.com' 
AND type = 'login_mfa';
```

### Check Session:
```php
// In tinker or controller
session('login_attempt');
// Should show: ['user_id' => 1, 'email' => 'user@email.com', 'remember' => false]
```

### Check Logs:
```bash
# Watch real-time logs
php artisan tail

# Or tail file
tail -f storage/logs/laravel.log
```

---

## 📊 Test Checklist

```
LOGIN FLOW
□ Password correct → Redirect to PIN form
□ Password wrong → Show error, stay on login
□ Email sent → Check inbox/logs
□ PIN received → Email arrives within 1 sec

PIN VERIFICATION
□ Valid PIN → Login successful
□ Wrong PIN → Show error, allow retry
□ PIN format → Must be 4 digits only
□ Non-numeric → Blocked/ignored
□ Empty PIN → Form validation error

SECURITY
□ PIN expires after 10 min
□ Max 5 attempts enforced
□ Session required for PIN form
□ PIN consumed after use
□ Session regenerated after login
□ Logout clears session

USER EXPERIENCE
□ Clear error messages
□ Email display shows where PIN sent
□ Auto-focus on PIN input
□ Visual feedback on input
□ Back to login link available
□ Security notice visible
□ Mobile responsive

EDGE CASES
□ Close browser → Session lost
□ Multiple login attempts → Latest PIN is valid
□ PIN in URL → Not possible (POST only)
□ Direct /login/verify-pin access → Redirect if no session
□ Stay on page > 10 min → PIN expires
```

---

## 🚨 Common Issues & Solutions

### Issue: "No email received"
**Check:**
```bash
# Check logs for sending errors
grep -i "mail" storage/logs/laravel.log

# Check MAIL_DRIVER setting
grep MAIL_DRIVER .env

# Verify email address
echo "Registered as: $email"
```

**Solution:**
- Set `MAIL_DRIVER=log` to see emails in logs
- Use Mailtrap/Mailgun for testing SMTP
- Check from email address is configured

---

### Issue: "PIN form shows blank/wrong email"
**Check:**
```php
// Verify session was created
session('login_attempt')
```

**Solution:**
- Ensure login() method stores session
- Check routes are correct
- Verify middleware 'guest' is applied

---

### Issue: "PIN verified but not logging in"
**Check:**
```php
// Check if Auth::login is called
// Check User model exists
Auth::check() // Should be true after login
```

**Solution:**
- Verify User model is correct
- Check verifyLoginPin() has Auth::login() call
- Check session regeneration happens

---

### Issue: "Attempts always at 5"
**Check:**
```sql
SELECT attempts FROM verification_codes 
WHERE email = 'user@email.com' 
ORDER BY created_at DESC LIMIT 1;
```

**Solution:**
- New PIN should reset attempts to 0
- Old PINs are deleted by generate()
- Check timing of PIN generation

---

## 📈 Performance Testing

### Response Times:
```
Login form load:        < 200ms
Password validation:    < 50ms
PIN generation:         < 50ms
PIN email send:         < 500ms (async)
PIN verification:       < 100ms
Session creation:       < 50ms
```

### Load Testing:
```bash
# Simulate 10 concurrent logins
ab -n 10 -c 10 http://localhost:8000/login

# Monitor with:
php artisan monitor
```

---

## ✅ Final Verification

Before considering MFA ready:

- [ ] PIN generation works
- [ ] PIN email delivery works
- [ ] PIN verification passes
- [ ] Login successful after PIN
- [ ] Session properly created
- [ ] Logout works properly
- [ ] Error handling correct
- [ ] Security checks working
- [ ] Mobile responsive
- [ ] Documentation complete

---

## 🎯 Success Criteria

```
MUST HAVE:
✅ PIN generated and emailed
✅ PIN form displays correctly
✅ PIN verified successfully
✅ User logged in after PIN
✅ Errors handled properly

SHOULD HAVE:
✅ Clear user messages
✅ Email within 1 second
✅ Mobile-friendly
✅ Accessible (WCAG)

NICE TO HAVE:
✅ Auto-submit on 4 digits
✅ Copy-paste friendly
✅ Visual countdown timer
✅ Resend PIN option
```

---

## 🚀 Once Tests Pass

```bash
# Clear test data
php artisan tinker
>>> \App\Models\VerificationCode::truncate()

# Run full test suite
php artisan test

# Check logs
tail -n 50 storage/logs/laravel.log

# Deploy to staging
# ... deployment process ...

# Monitor in production
# ... monitoring setup ...
```

---

## 📝 Notes

- PIN is 4-digit random (0000-9999)
- TTL is 10 minutes
- Max attempts is 5
- Consumed after one use
- Email-based (not SMS)
- No backup codes (yet)
- Session-based (not persistent token)

---

**Time Estimate:** 5-10 minutes per scenario  
**Total Testing:** ~45 minutes for full coverage  
**Status:** Ready for UAT

---

*For detailed technical info, see MFA_LOGIN_GUIDE.md*
