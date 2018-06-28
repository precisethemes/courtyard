module.exports = function (grunt) {
    'use strict';

    /**
     * Project configuration
     */
    var autoprefixer    = require('autoprefixer');
    var flexibility     = require('postcss-flexibility');

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        /**
         * Vendar prefixes
         */
        postcss: {
            options: {
                map: false,
                processors: [
                    flexibility,
                    autoprefixer({
                        browsers: [
                            'Android >= 2.1',
                            'Chrome >= 21',
                            'Edge >= 12',
                            'Explorer >= 7',
                            'Firefox >= 17',
                            'Opera >= 12.1',
                            'Safari >= 6.0'
                        ],
                        cascade: false
                    })
                ]
            },
            style: {
                expand: true,
                src: [
                    'style.css',
                    'assets/css/editor-style.css',
                ]
            }
        },

        /**
         * JS Minify
         */
        uglify: {
            js: {
                options: {
                    mangle: {
                        reserved: ['jQuery']
                    }
                },
                files: [
                    { // Front End
                        expand: true,
                        src: [
                            'js/*.js',
                            '!js/*.min.js'
                        ],
                        dest: 'js',
                        cwd: '.',
                        rename: function (dst, src) {
                            // To keep the source js files and make new files as `*.min.js`:
                            return src.replace('.js', '.min.js');
                        }
                    },
                    { // Back End
                        expand: true,
                        src: [
                            'js/admin/*.js',
                            '!js/admin/*.min.js'
                        ],
                        dest: 'js/admin',
                        cwd: '.',
                        rename: function (dst, src) {
                            // To keep the source js files and make new files as `*.min.js`:
                            return src.replace('.js', '.min.js');
                        }
                    }
                ]
            }
        },

        /**
         * CSS Minify
         */
        cssmin: {
            options: {
                keepSpecialComments: 0
            },
            css: {
                files: [
                    { // Front End
                        expand: true,
                        src: [
                            'css/*.css',
                            '!css/*.min.css'
                        ],
                        dest: 'css',
                        cwd: '.',
                        rename: function (dst, src) {
                            // To keep the source css files and make new files as `*.min.css`:
                            return src.replace('.css', '.min.css');
                        }
                    },
                    { // Back End
                        expand: true,
                        src: [
                            'css/admin/*.css',
                            '!css/admin/*.min.css'
                        ],
                        dest: 'css/admin',
                        cwd: '.',
                        rename: function (dst, src) {
                            // To keep the source css files and make new files as `*.min.css`:
                            return src.replace('.css', '.min.css');
                        }
                    }
                ]
            }
        },

        /**
         * Copy files
         */
        copy: {
            main: {
                options: {
                    mode: true
                },
                src: [
                    '**',
                    '!style - Copy.css',
                    '!node_modules/**',
                    '!build/**',
                    '!css/sourcemap/**',
                    '!.git/**',
                    '!bin/**',
                    '!.gitlab-ci.yml',
                    '!bin/**',
                    '!tests/**',
                    '!phpunit.xml.dist',
                    '!*.sh',
                    '!*.map',
                    '!.gitignore',
                    '!phpunit.xml',
                    '!README.md',
                    '!CONTRIBUTING.md',
                    '!codesniffer.ruleset.xml',
                    '!phpcs.ruleset.xml',

                    /**
                     * Are you developer? Then add below files.
                     */
                    '!Gruntfile.js',
                    '!package.json',
                    '!assets/sass/**',
                ],
                dest: 'courtyard/'
            }
        },

        /**
         * Compress files
         */
        compress: {
            main: {
                options: {
                    archive: 'courtyard.zip',
                    mode: 'zip'
                },
                files: [
                    {
                        src: [
                            './courtyard/**'
                        ]

                    }
                ]
            }
        },

        /**
         * Clean files
         */
        clean: {
            main: ["courtyard"],
            zip: ["courtyard.zip"]

        },

        /**
         * Generate POT
         */
        makepot: {
            target: {
                options: {
                    domainPath: '/',
                    potFilename: 'languages/courtyard.pot',
                    potHeaders: {
                        poedit: true,
                        'x-poedit-keywordslist': true
                    },
                    type: 'wp-theme',
                    updateTimestamp: true
                }
            }
        },

        /**
         * Add textdomain
         */
        addtextdomain: {
            options: {
                textdomain: 'courtyard',
            },
            target: {
                files: {
                    src: [
                        '*.php',
                        '**/*.php',
                        '!node_modules/**',
                        '!php-tests/**',
                        '!bin/**',
                    ]
                }
            }
        },

        /**
         * Check textdomain
         */
        checktextdomain: {
            standard: {
                options:{
                    text_domain: 'courtyard', //Specify allowed domain(s)
                    keywords: [ //List keyword specifications
                        '__:1,2d',
                        '_e:1,2d',
                        '_x:1,2c,3d',
                        'esc_html__:1,2d',
                        'esc_html_e:1,2d',
                        'esc_html_x:1,2c,3d',
                        'esc_attr__:1,2d',
                        'esc_attr_e:1,2d',
                        'esc_attr_x:1,2c,3d',
                        '_ex:1,2c,3d',
                        '_n:1,2,4d',
                        '_nx:1,2,4c,5d',
                        '_n_noop:1,2,3d',
                        '_nx_noop:1,2,3c,4d'
                    ]
                },
                files: [{
                    src: [
                        '**/*.php', //all php
                        '!node_modules/**'
                    ],
                    expand: true,
                }],
            }
        },
    });

    /**
     * Load Grunt Tasks
     */
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-wp-i18n');
    grunt.loadNpmTasks('grunt-checktextdomain');


    // Compile & Generate CSS & RTL from SCSS
    grunt.registerTask('style', ['postcss:style']);

    // Minify JS & CSS
    grunt.registerTask('minify', ['style', 'uglify:js', 'cssmin:css']);

    // Generate Release package
    grunt.registerTask('release', ['clean:zip', 'copy', 'compress', 'clean:main']);

    // i18n
    grunt.registerTask('i18n', ['checktextdomain', 'addtextdomain', 'makepot']);

    grunt.util.linefeed = '\n';
};