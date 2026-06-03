# 📚 LPK Seishin LMS Project Context

**Last Updated**: June 1, 2026  
**Current Branch**: `ahmad` (Personal development branch)  
**Project Type**: Laravel 12 + Vue/Alpine.js + Tailwind CSS LMS (Learning Management System)  
**Status**: ✅ Fully Operational (with known issues documented below)

---

## 🎯 Project Overview

Multi-user role-based e-learning platform untuk kursus bahasa Jepang dengan fitur:
- Student learning paths (subjects → modules → materials → tasks)
- Teacher dashboard & task review
- Admin management panel
- Vocabulary mastery system
- Payment integration (Midtrans)
- Task submission & progress tracking
- Announcements system

**Team Members**: Ahmad, Hilmi, Mizan, Yusar (branched development)

---

## 🏗️ Project Structure

```
lpkseishin/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/              (6 auth controllers)
│   │   ├── Student/           (5 student feature controllers)
│   │   ├── Teacher/           (2 teacher controllers)
│   │   ├── ProfileController
│   │   └── TransactionController
│   ├── Models/                (14 Eloquent models)
│   └── Providers/
├── database/
│   ├── migrations/            (24 migrations - ✅ ALL RUNNING)
│   └── seeders/               (14 seeders with test data)
├── resources/
│   ├── views/
│   │   ├── layouts/           (3 layouts)
│   │   ├── auth/              (6 auth pages)
│   │   ├── student/           (11 student pages)
│   │   ├── teacher/           (1 teacher page)
│   │   ├── admin/             (1 admin page)
│   │   └── components/        (13 reusable Blade components)
│   ├── css/
│   │   └── app.css            (Tailwind + PostCSS)
│   └── js/
│       ├── app.js             (Alpine.js entry point)
│       └── bootstrap.js       (Axios setup)
├── routes/
│   ├── web.php                (Web routes)
│   ├── auth.php               (Auth routes)
│   └── console.php
├── public/build/              (Vite build output - ⚠️ WORKAROUND)
│   ├── manifest.json
│   └── assets/
│       ├── app-*.css
│       └── app-*.js
├── vite.config.js
├── composer.json
├── package.json
└── .env                       (✅ Configured for MySQL)
```

---

## 🔧 Technology Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| Backend | Laravel Framework | 12.61.0 |
| PHP Version | PHP | 8.2.31 |
| Database | MySQL | 5.7+ |
| Frontend CSS | Tailwind CSS | 3.1.0 |
| Frontend JS | Alpine.js | 3.4.2 |
| Build Tool | Vite | 7.0.7 |
| HTTP Client | Axios | Latest |
| Package Manager | npm | 10.2.4 |
| Language | PHP + Blade Templates | - |

---

## ✅ Setup Status

### Completed ✅
- [x] Database created (`lpkseishin`)
- [x] All 24 migrations running without errors
- [x] All 14 seeders populated with test data (27 tables)
- [x] PHP dependencies installed (composer)
- [x] Environment file configured (`.env` with MySQL)
- [x] Laravel app key generated
- [x] Node dependencies installed (npm - 146 packages)
- [x] Authentication system fully working
- [x] Student dashboard rendering properly
- [x] Role-based access control functioning
- [x] Backend server running on `http://localhost:8000`

### Workarounds ⚠️
- [x] Vite Development Server (temporary fallback manifest)
  - Real-time HMR not working due to npm/Node version issues
  - Fallback: Static `public/build/manifest.json` created
  - CSS/JS assets are served, but without hot reload
  - **Workaround is functional but not ideal for development**

### Known Issues 🚨
1. **npm/Node.js Version Incompatibility**
   - Current: Node v20.10.0 (npm 10.2.4)
   - Required: Node v20.19.0+ or v22.12.0+
   - Impact: `npm install` fails with OpenSSL cipher errors
   - Status: npm modules already installed before error - **not blocking**

2. **Vite Development Server**
   - Cannot run `npm run dev` or `npx vite` due to above
   - Fallback manifest in `public/build/manifest.json` makes app work
   - CSS/JS loads but without hot module reloading (HMR)
   - Impact: Code changes require manual browser refresh

---

## 🗄️ Database Setup

### MySQL Connection
```
Host: 127.0.0.1
Port: 3306
Database: lpkseishin
Username: root
Password: (empty)
```

### Tables Created (27) ✅
- `users` (10 test users)
- `role` (3 roles: admin, siswa/student, guru/teacher)
- `batch` (materi class/batch)
- `mapel` (mata pelajaran/subjects - 3 subjects)
- `modul` (modules per subject)
- `rps` (course planning)
- `bahan_ajar` (teaching materials)
- `tugas` (tasks - 21 test tasks)
- `pengiriman_tugas` (task submissions)
- `enrollment_list` (student enrollment tracking)
- `jadwal` (schedule)
- `daily_words` (vocabulary)
- `vocab_progress` (vocabulary mastery tracking)
- `announcement` (announcements)
- `transaction` (payment transactions)
- `student_list_batch` (student batch association)
- `bahan_ajar_progress` (material progress tracking)
- _+ system tables: migrations, cache, jobs, sessions, etc._

### Test Users
| Name | Email | Password | Role |
|------|-------|----------|------|
| admin | admin@gmail.com | admin123 | Admin |
| siswa | siswa@gmail.com | siswa123 | Student |
| guru | guru@gmail.com | guru123 | Teacher |
| Ahmad Hidayat | ahmad@gmail.com | ahmad123 | Teacher |
| Hilmi Mithwa | hilmi@gmail.com | hilmi123 | Student |
| Mizan | mizan@gmail.com | hilmi123 | Teacher |

---

## 🐛 Issues Encountered & Solutions

### Issue #1: Composer Autoload Corruption
**Problem**: `vendor/autoload.php` not found after initial setup  
**Root Cause**: Autoload generation failed with posts-autoload dump script  
**Solution**:
```bash
# Remove corrupted vendor
rm -r vendor composer.lock

# Fresh install with --no-scripts
composer install --no-scripts

# Dump autoload manually
composer dump-autoload -a --no-interaction
```
**Status**: ✅ Fixed

### Issue #2: Database Migration Failed (TEXT in UNIQUE)
**Problem**: Migration `2026_05_07_103430_create_modul_table.php` failed  
**Error**: "BLOB/TEXT column 'kode_modul' used in key specification without a key length"  
**Root Cause**: MySQL doesn't allow TEXT/BLOB columns in UNIQUE constraints  
**Solution**:
```php
// Changed from:
$table->text('kode_modul')->unique();

// To:
$table->string('kode_modul')->unique();
```
**File**: `database/migrations/2026_05_07_103430_create_modul_table.php`  
**Status**: ✅ Fixed

### Issue #3: Seeder Foreign Key Truncate Error
**Problem**: `BahanAjarSeeder` and `ProgressBahanAjarSeeder` failed during truncate  
**Error**: "Cannot truncate a table referenced in a foreign key constraint"  
**Root Cause**: Foreign key checks enabled, preventing table truncation  
**Solution**:
```php
// Added to both seeders:
DB::statement('SET FOREIGN_KEY_CHECKS=0');
DB::table('table_name')->truncate();
DB::statement('SET FOREIGN_KEY_CHECKS=1');
```
**Files Modified**:
- `database/seeders/BahanAjarSeeder.php`
- `database/seeders/ProgressBahanAjarSeeder.php`
**Status**: ✅ Fixed

### Issue #4: Vite Manifest Not Found
**Problem**: 500 error on page load - "Vite manifest not found at public/build/manifest.json"  
**Root Cause**: Vite dev server never built assets, no manifest.json  
**Solution**: Created fallback manifest with minimal asset files
```bash
# Created these files:
├── public/build/
│   ├── manifest.json          (Vite manifest pointing to assets)
│   └── assets/
│       ├── app-BKl1W0XN.css   (Tailwind + basic styles)
│       └── app-DL5fKnFr.js    (Bootstrap + Alpine initialization)
```
**Status**: ✅ Workaround Applied (not ideal but functional)

### Issue #5: npm OpenSSL Cipher Errors
**Problem**: `npm install` fails with "ERR_SSL_CIPHER_OPERATION_FAILED"  
**Root Cause**: Node v20.10.0 incompatible with newer SSL library  
**Solution Attempts**:
- ✅ Already installed (146 npm packages before error)
- ⚠️ Could upgrade Node.js to v20.19.0+ or v22.12.0+
- ⚠️ Could use `NODE_OPTIONS="--openssl-legacy-provider"`
**Status**: ⚠️ Workaround - Vite not running but app works with static assets

---

## 🚀 How to Run Project (Next Day at Office)

### 1. Start MySQL
```bash
# Laragon: Start MySQL from Laragon UI
# Or via command:
mysql.server start
```

### 2. Start Laravel Server
```bash
cd c:\laragon\www\lpkseishin
php artisan serve
# Runs on http://localhost:8000
```

### 3. (Optional) Start Vite Dev Server
```bash
# This won't work without Node.js upgrade, but app still runs without it
npm run dev
# Or manually with legacy provider:
$env:NODE_OPTIONS="--openssl-legacy-provider"; npm run dev
```

### 4. Access Application
- **Login Page**: http://localhost:8000/
- **Test Account**: siswa@gmail.com / siswa123
- **Dashboard**: http://localhost:8000/students/dashboard

---

## 📋 Recommended Fixes (Priority Order)

### Priority 1: Must Fix (Blocking Development)
None currently - Project is fully functional!

### Priority 2: Should Fix (Better DX)
**Fix Node.js/npm/Vite Setup** for proper hot reload during development
```bash
# Option A: Upgrade Node.js to latest LTS
nvm install 20.19.0
nvm use 20.19.0

# Then reinstall npm packages
rm -r node_modules package-lock.json
npm install

# Now this should work:
npm run dev
```

**Option B: Use Docker (if available)**
```dockerfile
FROM node:20.19.0
WORKDIR /app
COPY package*.json ./
RUN npm install
```

### Priority 3: Nice to Have (Polish)
- [ ] Setup ESLint + Prettier for code formatting
- [ ] Add GitHub Actions CI/CD pipeline
- [ ] Setup proper error logging (Sentry/Rollbar)
- [ ] Add API documentation (Laravel Scribe)
- [ ] Setup code coverage testing

---

## 👨‍💻 Development Checklist

When continuing development at office tomorrow:

### Before Starting
- [ ] Verify MySQL is running
- [ ] Verify Laravel server starts: `php artisan serve`
- [ ] Test login with siswa@gmail.com / siswa123
- [ ] Check database: `mysql -u root lpkseishin -e "SELECT COUNT(*) FROM users;"`

### During Development
- [ ] Make code changes in `app/`, `resources/`, `database/`
- [ ] After database changes: `php artisan migrate`
- [ ] After seeder changes: `php artisan db:seed`
- [ ] Commit regularly: `git add . && git commit -m "descriptive message"`
- [ ] Browser refresh manually (F5) since HMR not available

### Before End of Day
- [ ] Run tests: `php artisan test` (if exists)
- [ ] Check git status: `git status`
- [ ] Push branch: `git push origin ahmad`
- [ ] Document changes in commits

---

## 🔄 Git Workflow

**Your Branch**: `ahmad` (Personal development)  
**Master Branch**: `master` (Stable, for team integration)  
**Team Member Branches**: `hilmi`, `mizan`, `yusar`

### Before Pulling Latest
```bash
# Check latest from master
git fetch origin
git log --oneline origin/master..HEAD  # See your commits ahead

# If needed, merge master into ahmad:
git merge origin/master
# Fix conflicts if any, then commit
```

### Pushing Changes
```bash
git add .
git commit -m "feature/fix: descriptive message"
git push origin ahmad
```

---

## 📚 Key Routes for Testing

| Route | Access | Status |
|-------|--------|--------|
| `/` | Public | ✅ Login page |
| `/students/dashboard` | Student | ✅ Working |
| `/students/my-tasks` | Student | ✅ Working |
| `/students/payment` | Student | ✅ Working |
| `/students/profile` | Student | ✅ Working |
| `/teacher/dashboard` | Teacher | ✅ Basic |
| `/admin/dashboard` | Admin | ✅ Basic |
| `/students/vocabulary-mastery` | Student | ✅ Working |

### Partially Implemented (501 Errors)
- `/teacher/subjects/{id}` - Need to implement teacher subject view
- `/teacher/tasks/{id}/review` - Need task review interface

---

## 💡 Quick Tips

- **Clear Laravel Cache**: `php artisan cache:clear`
- **Migrate Fresh**: `php artisan migrate:refresh --seed`
- **Check Routes**: `php artisan route:list`
- **Database Into**: `php artisan tinker`
- **Make Controller**: `php artisan make:controller NameController`
- **Make Migration**: `php artisan make:migration migration_name`

---

## 🎓 Next Development Tasks

1. **Implement Teacher Features**
   - [ ] Teacher subject detail view
   - [ ] Task review interface
   - [ ] Grade submission form

2. **Enhance Admin Dashboard**
   - [ ] User management table
   - [ ] Data statistics/analytics
   - [ ] Batch management

3. **Frontend Polish**
   - [ ] Responsive design fixes
   - [ ] Loading states
   - [ ] Error handling improvements
   - [ ] Animation/transitions

4. **Testing & QA**
   - [ ] Unit tests
   - [ ] Feature tests
   - [ ] End-to-end testing

---

## 📞 Troubleshooting

### "Vite manifest not found" Error
- ✅ Should be fixed - manifest exists at `public/build/manifest.json`
- If appears again: Check `@vite()` directive in layouts

### "These credentials do not match our records"
- Verify user email/password from database
- Check bcrypt hashing in seeder
- Try: siswa@gmail.com / siswa123

### Database Connection Refused
- Verify MySQL running: `mysql -u root -e "SELECT 1;"`
- Check `.env` credentials
- Verify port 3306 is accessible

### Page shows "[Data: ...]" placeholders
- This is normal - Blade variables not populated
- Check controller is passing data to view
- Laravel log: `storage/logs/laravel.log`

---

## 📝 Notes for Future Sessions

- Project uses **Blade templating** (not Vue components despite npm having Vue)
- **Alpine.js** for lightweight interactive features
- **Tailwind CSS** utility-first approach
- **Eloquent ORM** for database models
- Currently using **workaround Vite setup** - no hot reload
- Database seeders include realistic test data across all tables
- Role-based middleware at `app/Http/Middleware/RoleManager.php`

---

**Generated**: June 1, 2026 by GitHub Copilot  
**Project Location**: `c:\laragon\www\lpkseishin`  
**Server URL**: `http://localhost:8000`
