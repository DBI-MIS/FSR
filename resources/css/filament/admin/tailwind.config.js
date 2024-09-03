import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/views/infolists/components/*.blade.php',
        './resources/views/filament/part/*.blade.php',
        './resources/views/filament/daily-kanban/*.blade.php',
        './resources/views/filament/widgets/*.blade.php',
        './resources/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    
}
