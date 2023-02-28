// tailwind.config.js
module.exports = {
    content: ["./resources/**/*.{vue,js,php}"],
    safelist: [
        'doc-text-primary-500',
        'hover:doc-text-primary-700',
        'doc-text-gray-700',
        'dark:doc-text-gray-100',
        'dark:hover:doc-text-primary-200',
    ],
    corePlugins: {
        preflight: false,
    },
    darkMode: 'media',
    theme: {
        extend: {
            colors: {
                'primary': {
                    '50': 'rgb(var(--colors-primary-50))',
                    '100': 'rgb(var(--colors-primary-100))',
                    '200': 'rgb(var(--colors-primary-200))',
                    '300': 'rgb(var(--colors-primary-300))',
                    '400': 'rgb(var(--colors-primary-400))',
                    '500': 'rgb(var(--colors-primary-500))',
                    '600': 'rgb(var(--colors-primary-600))',
                    '700': 'rgb(var(--colors-primary-700))',
                    '800': 'rgb(var(--colors-primary-800))',
                    '900': 'rgb(var(--colors-primary-900))',
                },
                'gray': {
                    '50': 'rgb(var(--colors-gray-50))',
                    '100': 'rgb(var(--colors-gray-100))',
                    '200': 'rgb(var(--colors-gray-200))',
                    '300': 'rgb(var(--colors-gray-300))',
                    '400': 'rgb(var(--colors-gray-400))',
                    '500': 'rgb(var(--colors-gray-500))',
                    '600': 'rgb(var(--colors-gray-600))',
                    '700': 'rgb(var(--colors-gray-700))',
                    '800': 'rgb(var(--colors-gray-800))',
                    '900': 'rgb(var(--colors-gray-900))',
                }
            },
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        fontFamily: theme('fontFamily.sans').join(", "),

                        'h1, h2, h3, h4, h5, h6, p, ol, ul': {
                            'fontFamily': theme('fontFamily.sans').join(", "),
                        },
                        'h1, h2, h3': {
                            'color': 'rgb(var(--colors-gray-700))',
                        },
                        'h4, h5, h6': {
                            color: 'rgb(var(--colors-gray-500))',
                        },
                        h4: {
                            fontSize: '1.1em',
                        },
                        h5: {
                            fontSize: '1.03em',
                        },
                        'p, ul, ol, h1, h2, h3': {
                            marginBottom: theme('spacing.3'),
                        },
                        li: {
                            marginTop: '0.2em',
                            marginBottom: '0.2em',
                        },
                        a: {
                            color: 'rgb(var(--colors-primary-500))',
                            transition: 'all .125s ease-in-out',

                            '&:hover': {
                                color: 'rgb(var(--colors-primary-300))'
                            }
                        },
                        blockquote: {
                            margin: '10px 0 10px 30px',
                            paddingLeft: '15px',
                            borderLeft: '3px solid rgb(var(--colors-gray-300))',
                            borderRadius: '2px',
                        },
                        pre: {
                            border: '1px solid rgb(var(--colors-gray-200))',
                            padding: '0',
                            backgroundColor: 'rgb(var(--colors-gray-50)) !important',
                        },
                        hr: {
                            height: '1px',
                            backgroundColor: 'rgb(var(--colors-gray-300))',
                            margin: '20px 0',
                        },
                        table: {
                            borderCollapse: 'collapse',
                            borderRadius: '.5rem',
                            borderStyle: 'hidden',
                            boxShadow: '0 0 0 1px rgb(var(--colors-gray-600))',

                            'th, td': {
                                border: '1px solid rgb(var(--colors-gray-500))',
                                padding: '.75rem',
                            },
                            th: {
                                textAlign: 'left',
                                textTransform: 'uppercase',
                                letterSpacing: '.05rem',
                                fontSize: '.75rem',
                                color: 'rgb(var(--colors-gray-800))',
                                backgroundColor: 'rgb(var(--colors-gray-300))',

                                '&:first-child': {
                                    borderTopLeftRadius: '.5rem',
                                },
                                '&:last-child': {
                                    borderTopRightRadius: '.5rem',
                                },
                            },
                            td: {
                                color: 'rgb(var(--colors-gray-900))',
                                fontSize: '.875rem',
                            },
                        }
                    }
                },
                'invert': {
                    css: {
                        'h1, h2, h3': {
                            color: 'rgb(var(--colors-gray-100))',
                        },
                        'h4, h5, h6, ol, ul, p, blockquote': {
                            color: 'rgb(var(--colors-gray-300))',
                        },
                        pre: {
                            border: '1px solid rgb(var(--colors-gray-700))',
                            padding: '0',
                            backgroundColor: 'rgb(var(--colors-gray-900)) !important',
                        },
                        blockquote: {
                            borderLeft: '3px solid rgb(var(--colors-primary-300))',
                        },
                        table: {
                            boxShadow: '0 0 0 1px rgb(var(--colors-gray-800))',

                            th: {
                                color: 'rgb(var(--colors-gray-50))',
                                backgroundColor: 'rgb(var(--colors-gray-600))',
                            },
                            td: {
                                color: 'rgb(var(--colors-gray-200))',
                            },
                        }
                    }
                }
            }),
        }
    },
    variants: {},
    plugins: [
        require('@tailwindcss/typography'),
    ],
    prefix: 'doc-',
};