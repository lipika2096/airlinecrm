{{ \App\Helpers\TimezoneHelper::autoFormat($datetime, $format ?? 'Y-m-d H:i:s') }}

{{-- 
    Simple Datetime Component with Timezone Support
    
    Usage Examples:
    
    Basic usage:
    <x-datetime :datetime="$model->created_at" />
    
    Custom format:
    <x-datetime :datetime="$model->created_at" format="M d, Y H:i" />
    
    With null handling:
    <x-datetime :datetime="$model->nullable_date" format="M d, Y" />
    
    This component automatically handles timezone conversion
    without requiring any changes to existing code.
--}}