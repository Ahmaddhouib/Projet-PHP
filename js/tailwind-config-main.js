// Configuration Tailwind CSS pour la page d'accueil (ViewMain.php)
// Palette de couleurs Material Design adaptée au thème nature
tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            "colors": {
                "secondary-container": "#f0e8db",
                "on-primary": "#ffffff",
                "inverse-primary": "#8ecf9e",
                "on-surface": "#2e3230",
                "secondary": "#6b6358",
                "surface-variant": "#e4e0d8",
                "primary-container": "#78a886",
                "on-secondary-container": "#5e5548",
                "secondary-fixed": "#f0e8db",
                "on-secondary-fixed": "#1e1a13",
                "on-tertiary": "#ffffff",
                "on-error-container": "#690005",
                "surface-container-low": "#f5f1ea",
                "on-tertiary-container": "#554020",
                "error-container": "#ffdad8",
                "surface-dim": "#dbd7cf",
                "inverse-surface": "#2e3230",
                "tertiary": "#705c30",
                "on-surface-variant": "#4a4e4a",
                "inverse-on-surface": "#f5f0e8",
                "surface": "#faf6f0",
                "on-primary-fixed-variant": "#2a6038",
                "surface-tint": "#4a7c59",
                "on-background": "#2e3230",
                "surface-container": "#f0ece4",
                "on-secondary": "#ffffff",
                "primary": "#4a7c59",
                "on-primary-fixed": "#002110",
                "surface-container-lowest": "#ffffff",
                "background": "#faf6f0",
                "on-tertiary-fixed": "#221a05",
                "surface-container-highest": "#e4e0d8",
                "on-secondary-fixed-variant": "#4a4538",
                "primary-fixed": "#c8e8d0",
                "tertiary-fixed": "#f8e0a8",
                "primary-fixed-dim": "#8ecf9e",
                "outline": "#74796e",
                "on-error": "#ffffff",
                "surface-bright": "#faf6f0",
                "on-tertiary-fixed-variant": "#554020",
                "on-primary-container": "#d8f0de",
                "error": "#b83230",
                "tertiary-container": "#c4a66a",
                "tertiary-fixed-dim": "#dcc48e",
                "secondary-fixed-dim": "#d4ccbf",
                "outline-variant": "#c4c8bc",
                "surface-container-high": "#eae6de"
            },
            "borderRadius": {
                "DEFAULT": "0.5rem",
                "lg": "1rem",
                "xl": "1.5rem",
                "full": "9999px"
            },
            "fontFamily": {
                "headline": ["Literata", "serif"],
                "body": ["Nunito Sans", "sans-serif"],
                "label": ["Nunito Sans", "sans-serif"]
            }
        }
    }
}