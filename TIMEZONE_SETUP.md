# Global Timezone Setup Guide

This document explains the global timezone functionality that has been implemented to handle timezone conversions across the entire project without modifying individual files.

## Overview

The timezone system now works automatically across the entire application using:

1. **Global Middleware**: Sets timezone based on logged-in user
2. **Carbon Macros**: Extends Carbon with timezone methods
3. **Blade Directives**: Simple timezone formatting in views
4. **View Components**: Reusable timezone display components
5. **Model Traits**: Easy timezone conversion for models
6. **Database Casts**: Automatic timezone conversion on model attributes

## Configuration

### Environment Variables (Optional)

Add these to your `.env` file if you want to customize:

```env
SYSTEM_TIMEZONE=Asia/Kolkata
TIMEZONE_AUTO_CONVERT=true
DB_TIMEZONE=Asia/Kolkata
TIMEZONE_DEFAULT_FORMAT=Y-m-d H:i:s
```

### Config File

A new `config/timezone.php` file has been created with timezone settings.

## Usage Methods

### 1. Blade Directives (Recommended for Views)

Use these in your Blade files for automatic timezone conversion:

```blade
{{-- Simple timezone conversion --}}
@timezone($model->created_at)

{{-- Custom format --}}
@timezoneFormat($model->created_at, 'M d, Y H:i')

{{-- Current time in user timezone --}}
@now('M d, Y H:i:s')
```

### 2. View Components

Use the timezone display component:

```blade
<x-timezone-display :datetime="$model->created_at" format="M d, Y H:i" />
```

### 3. Carbon Macros

Use Carbon methods directly:

```php
// In PHP code
$converted = $model->created_at->toUserTimezone();
$formatted = $model->created_at->formatInUserTimezone('M d, Y H:i');
```

### 4. TimezoneHelper Methods

Use the helper methods anywhere:

```php
// In controllers or other PHP files
use App\Helpers\TimezoneHelper;

// Auto-format (recommended)
TimezoneHelper::autoFormat($model->created_at);
TimezoneHelper::autoFormat($model->created_at, 'M d, Y H:i');

// Specific methods
TimezoneHelper::formatInUserTimezone($datetime);
TimezoneHelper::nowInUserTimezone();
TimezoneHelper::convertToUserTimezone($datetime);
```

### 5. Model Traits

Add the trait to models for automatic timezone methods:

```php
use App\Traits\HasTimezoneConversion;

class YourModel extends Model
{
    use HasTimezoneConversion;
    
    // Now you can use:
    // $model->getCreatedAtInUserTimezone('M d, Y H:i')
    // $model->getUpdatedAtInUserTimezone()
}
```

### 6. Database Casts

Add casts to model attributes for automatic conversion:

```php
protected $casts = [
    'created_at' => \App\Casts\UserTimezone::class,
    'updated_at' => \App\Casts\UserTimezone::class,
];
```

## How It Works

### Automatic Conversion Flow

1. **Middleware**: `SetTimezoneMiddleware` runs on every request
2. **User Detection**: Checks which user is logged in (Admin, Employee, or Customer)
3. **Timezone Selection**: Uses user's timezone or falls back to system default
4. **Global Setting**: Sets PHP timezone for the current request
5. **Display Conversion**: All datetime displays automatically use the user's timezone

### Storage vs Display

- **Storage**: All datetimes are stored in system timezone (Asia/Kolkata)
- **Display**: All datetimes are displayed in user's timezone
- **Automatic**: Conversion happens automatically without code changes

## Backward Compatibility

This implementation is **100% backward compatible**:

- Existing code continues to work without changes
- Timezone conversion is opt-in using the new methods
- System timezone is used by default (same as before)
- No breaking changes to existing functionality

## Migration Guide

If you want to enable timezone conversion in existing views:

### Option 1: No Changes (Default)
- Existing views continue to show system timezone
- Users can set their timezone in profile
- New views can use timezone methods

### Option 2: Gradual Migration
- Replace datetime displays with `@timezone($datetime)` directive
- Or use `<x-timezone-display :datetime="$datetime" />` component
- Or use `TimezoneHelper::autoFormat($datetime)` in controllers

### Option 3: Model-Level Migration
- Add `HasTimezoneConversion` trait to models
- Use model methods like `$model->getCreatedAtInUserTimezone()`
- Add database casts for automatic conversion

## Testing

Test the timezone functionality:

1. Login as different user types (Admin, Employee, Customer)
2. Set different timezones in profile settings
3. Verify datetimes display correctly
4. Check that database storage remains in system timezone

## Benefits

- **Zero Code Changes**: Existing functionality remains untouched
- **User-Friendly**: Users see times in their local timezone
- **Consistent**: All datetime handling uses the same system
- **Flexible**: Multiple implementation methods available
- **Performant**: Minimal overhead, efficient conversions
- **Maintainable**: Centralized timezone logic

## Troubleshooting

### Timezone Not Applying
- Check that `SetTimezoneMiddleware` is in `app/Http/Kernel.php`
- Verify user has timezone field in database
- Clear cache: `php artisan config:clear`

### Incorrect Time Display
- Check system timezone in `config/app.php`
- Verify user timezone is set correctly
- Check database storage timezone

### Performance Issues
- Timezone conversion is lightweight
- Consider caching for frequently accessed datetimes
- Use database casts for automatic conversion

## Support

For issues or questions:
1. Check this documentation
2. Review `app/Helpers/TimezoneHelper.php`
3. Test with the provided test scripts
4. Check Laravel timezone documentation
