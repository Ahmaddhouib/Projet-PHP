// Configuration Tailwind CSS personnalisée pour la page de connexion
// Définit la palette "Nature's Breath" (verts/beiges) et les polices utilisées
tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            "colors": {
                "on-secondary-container": "#5e5548",
                "error-container": "#ffdad8",
                "surface-variant": "#e4e0d8",
                "surface-dim": "#dbd7cf",
                "on-error": "#ffffff",
                "on-background": "#2e3230",
                "on-tertiary-fixed": "#221a05",
                "primary": "#4a7c59",
                "on-secondary-fixed": "#1e1a13",
                "on-primary-fixed": "#002110",
                "on-error-container": "#690005",
                "on-primary-container": "#d8f0de",
                "primary-fixed": "#c8e8d0",
                "tertiary": "#705c30",
                "surface-container-low": "#f5f1ea",
                "secondary": "#6b6358",
                "inverse-primary": "#8ecf9e",
                "on-secondary": "#ffffff",
                "primary-container": "#78a886",
                "secondary-container": "#f0e8db",
                "on-primary-fixed-variant": "#2a6038",
                "tertiary-fixed-dim": "#dcc48e",
                "on-tertiary-fixed-variant": "#554020",
                "on-surface": "#2e3230",
                "inverse-on-surface": "#f5f0e8",
                "inverse-surface": "#2e3230",
                "surface": "#faf6f0",
                "surface-container": "#f0ece4",
                "on-tertiary": "#ffffff",
                "background": "#faf6f0",
                "tertiary-fixed": "#f8e0a8",
                "surface-container-lowest": "#ffffff",
                "on-primary": "#ffffff",
                "primary-fixed-dim": "#8ecf9e",
                "tertiary-container": "#c4a66a",
                "surface-container-high": "#eae6de",
                "surface-bright": "#faf6f0",
                "on-tertiary-container": "#554020",
                "outline": "#74796e",
                "outline-variant": "#c4c8bc",
                "error": "#b83230",
                "surface-tint": "#4a7c59",
                "on-surface-variant": "#4a4e4a",
                "secondary-fixed": "#f0e8db",
                "on-secondary-fixed-variant": "#4a4538",
                "surface-container-highest": "#e4e0d8",
                "secondary-fixed-dim": "#d4ccbf"
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
        },
    },
}