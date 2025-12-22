# Railway Deployment Guide

## Prerequisites
- Railway account (https://railway.app)
- GitHub repository connected to Railway
- MySQL database provisioned in Railway

## Step 1: Add MySQL Database

1. Go to your Railway project: https://railway.com/project/e0759efd-976f-4cc1-955d-8ac3480cf265
2. Click **"+ New"** → **"Database"** → **"Add MySQL"**
3. Railway will automatically create a MySQL database and provide connection details

## Step 2: Configure Environment Variables

Go to your service settings and add these environment variables:

### Required Variables

```env
# Application
APP_NAME="Chrey Shop"
APP_ENV=production
APP_KEY=                          # Generate with: php artisan key:generate --show
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (Railway will auto-fill these when you connect MySQL)
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}

# Session & Cache
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database

# Filesystem
FILESYSTEM_DISK=public

# Mail (optional - configure if needed)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@chrey.com"
MAIL_FROM_NAME="${APP_NAME}"

# Bakong Payment (configure with your credentials)
BAKONG_API_KEY=your-bakong-api-key
BAKONG_API_URL=https://api-bakong.nbc.gov.kh
BAKONG_TEST_MODE=false
BAKONG_MERCHANT_ID=your-merchant-id
BAKONG_MERCHANT_NAME="Chrey Shop"
BAKONG_MERCHANT_CITY="PHNOM PENH"
```

## Step 3: Generate APP_KEY

Run this command locally to generate an application key:

```bash
php artisan key:generate --show
```

Copy the generated key (starts with `base64:`) and add it to Railway's `APP_KEY` environment variable.

## Step 4: Deploy

### Option A: Automatic Deployment (Recommended)

1. Push your code to GitHub
2. Railway will automatically detect changes and deploy
3. Monitor the build logs in Railway dashboard

### Option B: Manual Deployment

1. In Railway dashboard, click **"Deploy"**
2. Railway will build and deploy your application

## Step 5: Post-Deployment

After the first deployment, the application will automatically:
- Run database migrations (`php artisan migrate --force`)
- Seed roles and permissions (`php artisan db:seed --force --class=RolePermissionSeeder`)
- Start the application

## Step 6: Access Your Application

1. Go to your service settings in Railway
2. Click **"Settings"** → **"Networking"**
3. Click **"Generate Domain"** if you haven't already
4. Your app will be accessible at: `https://your-app-name.up.railway.app`

## Important Configuration Notes

### Database Connection

Railway provides environment variables for MySQL. Make sure to use Railway's variable references:
- `${{MySQL.MYSQL_HOST}}`
- `${{MySQL.MYSQL_PORT}}`
- `${{MySQL.MYSQL_DATABASE}}`
- `${{MySQL.MYSQL_USER}}`
- `${{MySQL.MYSQL_PASSWORD}}`

### Storage

The application uses `public` disk for file storage. Uploaded files will be stored in the container, but note that Railway's filesystem is ephemeral. For production, consider using:
- AWS S3
- Cloudinary
- Railway Volumes (persistent storage)

To use Railway Volumes:
1. Go to your service → **"Variables"** → **"+ New Volume"**
2. Mount path: `/app/storage/app/public`

### Queue Workers (Optional)

If you need background job processing:

1. Create a new service in Railway
2. Use the same GitHub repository
3. Set environment variables (copy from main service)
4. Change the start command in `railway.json`:
   ```json
   {
     "build": {
       "builder": "NIXPACKS"
     },
     "deploy": {
       "startCommand": "php artisan queue:work --verbose --tries=3 --timeout=90"
     }
   }
   ```

## Troubleshooting

### Build Fails

1. Check build logs in Railway dashboard
2. Ensure all dependencies are in `composer.json` and `package.json`
3. Verify Node.js and PHP versions match your local environment

### Database Connection Error

1. Ensure MySQL database is added to your project
2. Verify environment variables are correctly set
3. Check that database variables use Railway's `${{MySQL.*}}` references

### 500 Error

1. Set `APP_DEBUG=true` temporarily to see error details
2. Check application logs in Railway dashboard
3. Ensure `APP_KEY` is set
4. Verify all environment variables are correct

### Storage Link Issues

The deployment automatically runs `php artisan storage:link`. If uploads don't work:
1. Check file permissions
2. Consider using cloud storage (S3, Cloudinary)
3. Use Railway Volumes for persistent storage

## Monitoring

- **Logs**: View real-time logs in Railway dashboard
- **Metrics**: Monitor CPU, memory usage in Railway dashboard
- **Alerts**: Set up alerts for service downtime

## Scaling

Railway's free tier includes:
- 500 hours of usage per month
- $5 free credit
- Shared resources

For production workloads, consider upgrading to a paid plan for:
- More resources
- Better performance
- Priority support

## Security Checklist

- ✅ `APP_DEBUG=false` in production
- ✅ `APP_ENV=production`
- ✅ Strong `APP_KEY` generated
- ✅ Database credentials secured
- ✅ HTTPS enabled (Railway provides this automatically)
- ✅ API keys secured in environment variables

## Additional Resources

- [Railway Documentation](https://docs.railway.app)
- [Laravel Deployment Documentation](https://laravel.com/docs/deployment)
- [Railway Discord Community](https://discord.gg/railway)