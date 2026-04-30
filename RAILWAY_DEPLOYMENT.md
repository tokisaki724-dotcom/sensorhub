# Railway Deployment Guide for SensorHub

## Pre-Deployment Checklist

### 1. Push Your Code to GitHub
```bash
git add .
git commit -m "Prepare for Railway deployment"
git push origin main
```

### 2. Generate APP_KEY
Run this command locally and save the output:
```bash
php artisan key:generate --show
```

## Railway Deployment Steps

### Step 1: Sign Up & Create Project
1. Go to [https://railway.app](https://railway.app)
2. Sign up/Login with GitHub
3. Click **"New Project"**
4. Select **"Deploy from GitHub repo"**
5. Connect your GitHub account
6. Select your SensorHub repository

### Step 2: Add PostgreSQL Database
1. In your Railway project dashboard, click **"+ New"**
2. Select **"Database"** → **"Add PostgreSQL"**
3. Railway will automatically provision a PostgreSQL database
4. The `DATABASE_URL` environment variable will be set automatically

### Step 3: Configure Environment Variables

In Railway dashboard, go to **Variables** tab and add:

#### Required Variables:
```
APP_NAME=SensorHub
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-project.railway.app
```

#### Mail Configuration (for email verification):
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@sensorhub.com
MAIL_FROM_NAME="SensorHub"
```

**Note for Gmail:**
- Use an App Password, not your regular Gmail password
- Generate it at: https://myaccount.google.com/apppasswords

### Step 4: Configure Build & Deploy

Railway will automatically use the `nixpacks.toml` file we created. The build process will:
1. Install PHP dependencies (composer install)
2. Install Node.js dependencies and build assets (npm install && npm run build)
3. Cache Laravel configuration
4. Run database migrations
5. Start the application

### Step 5: Deploy

1. Railway will automatically start deploying once you connect the repo
2. Monitor the deployment in the **Deployments** tab
3. Check logs for any errors

### Step 6: Post-Deployment Tasks

#### Run Database Seeders (Optional):
```bash
# In Railway dashboard, go to Console tab
php artisan db:seed --force
```

#### Clear Cache (if needed):
```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Create Admin User (if needed):
```bash
php artisan tinker
```
Then in tinker:
```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@sensorhub.com',
    'password' => bcrypt('your-secure-password'),
    'role' => 'admin',
    'email_verified_at' => now()
]);
```

## Important Configuration Notes

### 1. File Storage
Railway's filesystem is **ephemeral**. This means:
- Uploaded files will be lost on redeployment
- For production, you should use cloud storage

**Recommended Solutions:**
- AWS S3
- Cloudinary
- DigitalOcean Spaces

To configure S3:
```bash
composer require league/flysystem-aws-s3-v3
```

Update `.env`:
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
AWS_URL=https://your-bucket.s3.amazonaws.com
```

### 2. Session & Cache Configuration
Update these in Railway environment variables:
```
CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

Run migration for sessions:
```bash
php artisan session:table
php artisan migrate
```

### 3. Asset Building
The project uses Vite for asset compilation. The `nixpacks.toml` file handles this automatically.

If you need to build assets locally:
```bash
npm install
npm run build
```

### 4. Database Migrations
Migrations run automatically on each deployment via the `nixpacks.toml` start command.

## Troubleshooting

### Common Issues:

#### 1. "APP_KEY not found" error
- Make sure you've set the `APP_KEY` environment variable in Railway
- Format: `base64:xxxxxxxxxxxxxxxxxxxxx`

#### 2. Database connection errors
- Verify PostgreSQL service is attached to your project
- Check that `DATABASE_URL` is set automatically by Railway

#### 3. Assets not loading
- Check that `npm run build` completed successfully
- Verify `APP_URL` is set correctly

#### 4. Email verification not working
- Check mail configuration
- Verify SMTP credentials
- Check Railway logs for mail errors

#### 5. Permission errors
- Railway runs as root, so permission issues are rare
- If any occur, check storage and bootstrap/cache permissions

## Monitoring Your Deployment

### View Logs:
- Go to Railway dashboard → Your project → **Deployments** tab
- Click on the latest deployment → **View Logs**

### Access Console:
- Go to Railway dashboard → Your project → **Console** tab
- Run artisan commands directly

### Domain:
- Railway provides a free subdomain: `your-project.railway.app`
- You can add a custom domain in the **Settings** tab

## Updating Your Application

When you push new code to GitHub:
1. Railway will automatically detect changes
2. A new deployment will start
3. Monitor the deployment in the dashboard

To manually trigger a redeployment:
- Go to Railway dashboard → **Deployments** tab
- Click **"Redeploy"**

## Performance Optimization

### 1. Enable OPcache
Add to `nixpacks.toml`:
```toml
[variables]
PHP_OPCACHE_ENABLE="1"
```

### 2. Use Production Optimizations
The `nixpacks.toml` already includes:
- `php artisan optimize`
- Config caching
- Route caching
- View caching

### 3. Database Indexes
Make sure your migrations include proper indexes for frequently queried columns.

## Security Best Practices

1. **Never commit `.env` file** (already in `.gitignore`)
2. **Use strong passwords** for admin accounts
3. **Enable HTTPS** (Railway provides this automatically)
4. **Keep dependencies updated**
5. **Regular backups** of your database

## Backup Your Database

Export database:
```bash
pg_dump -h your-db-host -U your-user -d your-db > backup.sql
```

Import database:
```bash
psql -h your-db-host -U your-user -d your-db < backup.sql
```

## Support

- Railway Documentation: https://docs.railway.app
- Laravel Documentation: https://laravel.com/docs
- Railway Discord: https://discord.gg/railway

---

**Your Configuration Files:**
- ✅ `Procfile` - Web server configuration
- ✅ `railway.json` - Railway deployment schema
- ✅ `nixpacks.toml` - Build and deployment instructions

These files are ready for deployment. Just push to GitHub and connect to Railway!
