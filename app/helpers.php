<?php
function get_setting($name)
{
    $setting = \App\Models\Setting::where('name', $name)->first();
    return $setting ? $setting->value : null;
}
?>
