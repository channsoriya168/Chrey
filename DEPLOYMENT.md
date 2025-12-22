# 🚀 Free Deployment Guide for Chrey E-Commerce

## Option 1: Railway.app (Recommended) ⭐

Railway is the easiest and best free hosting option for Laravel applications.

### Free Plan Benefits:
- $5 monthly credit (renewable)
- PostgreSQL database included
- Automatic deployments from GitHub
- Easy environment variable management
- Custom domains support

### Step-by-Step Deployment:

#### 1. Prepare Your GitHub Repository

```bash
# Initialize git if not already done
git init

# Add all files
git add .

# Create initial commit
git commit -m "Initial commit - Ready for deployment"

# Create a new repository on GitHub (go to github.com)
# Then connect your local repo:
git remote add origin https://github.com/YOUR-USERNAME/chrey.git
git branch -M main
git push -u origin main
```

#### 2. Sign Up for Railway

1. Go to [railway.app](https://railway.app)
2. Click "Start a New Project"
3. Sign in with GitHub (it's free!)

#### 3. Create a New Project

1. Click "New Project"
2. Select "Deploy from GitHub repo"
3. Select your `chrey` repository
4. Railway will automatically detect it's a Laravel app

#### 4. Add PostgreSQL Database

1. In your project, click "+ New"
2. Select "Database" → "Add PostgreSQL"
3. Railway will automatically provision a free PostgreSQL database

#### 5. Configure Environment Variables

Go to your Laravel app service → "Variables" tab and add these:

```env
APP_NAME=Chrey
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

# Bakong Payment (Optional - add your credentials)
BAKONG_API_KEY=your_api_key
BAKONG_MERCHANT_ID=your_merchant_id
BAKONG_MERCHANT_NAME="Chrey Shop"
BAKONG_TEST_MODE=true
```

**Important:** Generate a new APP_KEY by running locally:
```bash
php artisan key:generate --show
```
Copy the output and paste it as `APP_KEY` in Railway.

#### 6. Deploy Settings

Railway should automatically deploy. If not:
1. Go to "Settings" → "Deploy"
2. Set "Build Command": (leave default)
3. Set "Start Command": (leave default - uses Procfile)

#### 7. Generate Domain

1. Go to "Settings" → "Networking"
2. Click "Generate Domain"
3. Your app will be available at: `https://your-app-name.up.railway.app`

#### 8. Run Database Migrations

After first deployment:
1. Go to your service → "Deployments" tab
2. Click on the latest deployment
3. Open "View Logs"
4. The migrations should run automatically

If they don't, manually run:
1. Click on your service
2. Go to "Settings" → "Deploy"
3. In "Custom Start Command", temporarily add:
   ```
   php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
   ```

---

## Option 2: Render.com

### Free Plan:
- Free tier available
- PostgreSQL database
- Auto-deploy from GitHub

### Steps:

1. **Sign Up:** [render.com](https://render.com)
2. **New Web Service:** Click "New +" → "Web Service"
3. **Connect GitHub:** Select your repository
4. **Configure:**
   - Name: `chrey`
   - Environment: `Docker`
   - Build Command: `composer install && npm ci && npm run build`
   - Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

5. **Add PostgreSQL:**
   - Click "New +" → "PostgreSQL"
   - Name it and connect to your web service

6. **Environment Variables:** Same as Railway above

---

## Option 3: Fly.io

### Free Tier:
- 3 shared CPU VMs
- PostgreSQL database
- 3GB storage

### Quick Start:

```bash
# Install Fly CLI
# Windows (PowerShell):
powershell -Command "iwr https://fly.io/install.ps1 -useb | iex"

# Create a Fly account
fly auth signup

# Launch your app
fly launch

# Follow the prompts
# When asked, say YES to:
# - PostgreSQL database
# - Deploy now

# Your app will be live at: https://your-app-name.fly.dev
```

---

## Post-Deployment Checklist

✅ **Test your application:**
- Homepage loads
- Products display correctly
- Cart functionality works
- Payment integration (if configured)

✅ **Set up custom domain** (optional):
- Railway: Settings → Networking → Custom Domain
- Point your domain's DNS to Railway

✅ **Monitor your app:**
- Check Railway dashboard for logs
- Monitor resource usage

✅ **Run database seeders** (optional):
```bash
# In Railway, go to Settings → Deploy
# Add to start command:
php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

---

## Troubleshooting

### Issue: "500 Internal Server Error"
**Solution:**
- Check logs in Railway dashboard
- Make sure `APP_KEY` is set
- Verify database connection variables

### Issue: "Mix manifest not found"
**Solution:**
- Make sure `npm run build` ran successfully
- Check build logs for errors

### Issue: "Database connection failed"
**Solution:**
- Verify all database environment variables
- Use `${{Postgres.VARIABLE_NAME}}` syntax in Railway

### Issue: "Styles not loading"
**Solution:**
- Clear config cache: Add to start command temporarily:
  ```
  php artisan config:clear && php artisan serve --host=0.0.0.0 --port=$PORT
  ```

---

## Free Alternatives Comparison

| Platform | Pros | Cons |
|----------|------|------|
| **Railway** ⭐ | Easiest setup, Great for Laravel, Auto-deploy | $5/month credit limit |
| **Render** | Good free tier, Simple | Slower cold starts |
| **Fly.io** | More resources, Good docs | Requires CLI setup |

---

## Need Help?

1. **Railway Docs:** [docs.railway.app](https://docs.railway.app)
2. **Laravel Deployment:** [laravel.com/docs/deployment](https://laravel.com/docs/deployment)
3. **Community:** Railway Discord or Laravel Forums

---

**Good luck with your deployment! 🚀**
