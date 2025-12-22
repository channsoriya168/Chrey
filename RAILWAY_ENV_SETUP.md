# Railway Environment Variables Setup

## Critical: Set these in Railway Dashboard

Go to your Railway project → Select your service → Variables tab

### 1. Database Connection (After adding MySQL service)

```env
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}
```

### 2. Application Settings

```env
APP_NAME="Chrey"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://chrey-production.up.railway.app
APP_KEY=base64:2I5iKC/0JChozjtLETDeMijgylltBpWAxRZVhF+P9aw=
```

### 3. Session & Cache

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### 4. Bakong Payment (if needed)

```env
BAKONG_API_KEY=your_api_key
BAKONG_API_URL=https://api-bakong.nbc.gov.kh
BAKONG_TEST_MODE=false
BAKONG_MERCHANT_ID=your_merchant_id
```

## Quick Setup Steps

1. **Add MySQL Database**
   - Click "+ New" → "Database" → "MySQL"
   - Wait for it to provision

2. **Link Database Variables**
   - Railway auto-creates variables when you add MySQL
   - Use the variable references shown above (e.g., `${{MySQL.MYSQL_HOST}}`)

3. **Set Application Variables**
   - Copy the APP_KEY from your local .env
   - Set APP_URL to your Railway domain
   - Set APP_ENV=production and APP_DEBUG=false

4. **Redeploy**
   - Push your latest changes to GitHub
   - Railway will auto-deploy

## Troubleshooting

### 502 Bad Gateway
- Check deployment logs in Railway dashboard
- Verify database is running and connected
- Make sure all environment variables are set

### Database Connection Errors
- Ensure MySQL service is added to your project
- Check that variable references use correct syntax: `${{MySQL.VARIABLE_NAME}}`

### Build Failures
- Check that all dependencies are in package.json and composer.json
- Ensure nixpacks.toml is properly configured
