{{ $converted }}

{{-- 
    Timezone Display Component
    
    Usage: <x-timezone-display :datetime="$model->created_at" format="M d, Y H:i" />
    
    This component automatically converts system timezone to user timezone
    without requiring any changes to existing code.
--}}