module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        babel: {
            options: {
                sourceMap: false,
                presets: ['es2015']
            },
            dist: {
                files: {
                    'js/compiled.js': 'js/functions.jsx'
                }
            }
        },
        exec:{
            activate_theme:'wp theme activate banana-cream --allow-root --quiet',
            activate_plugins:'wp plugin activate tf-core carbon-fields wordpress-seo list-field-number-format-for-gravity-forms tf-sharing-controls gravityforms --allow-root --quiet',
            get_updates: 'git pull <%= pkg.repository.url %> master && git submodule update --init --recursive'
        },
        sass:{
            dist:{
                options:{
                    sourcemap:'none',
                    style:'compressed',
                    lineNumbers: false
                },
                files:{
                    'style.min.css' : 'css/sass/main.scss'
                }
            },
            dev:{
                options:{
                    sourcemap:'none',
                    style:'expanded'
                },
                files:{
                    'style.css' : 'css/sass/main.scss'
                }
            }
        },
        watch:{
            css:{
                files:['css/sass/*.scss','inc/NP_GF_Field_Star_Rating/*.scss'],
                tasks:['sass']
            },
            js:{
                files:['js/functions.jsx'],
                tasks:[ 'babel', 'uglify', 'bundles']
            }
        },
        uglify:{
            options: {
                banner: '/*! <%= pkg.name %> v<%= pkg.version %> */\n',
                compress: true
            },
            build: {
                src: ['js/bundle.js'],
                dest: 'js/bundle.min.js'
            }
        },
        bundles:{
            options:{

            },
            app: {
                dest    : "js/bundle.js",
                exec    : {
                    src : [
                    'bower_components/uikit/js/uikit.js',
                    'bower_components/uikit/js/core/grid.js', //needed for grid layouts. used everywhere
                    'bower_components/uikit/js/core/nav.js', //needed for the offcanvas menu
                    'bower_components/uikit/js/core/offcanvas.js', //needed for the offcanvas menu
                    'bower_components/uikit/js/components/grid.js', //needed for grid layouts. used everywhere
                    'bower_components/uikit/js/components/lightbox.js', //needed for full preview of images
                    'bower_components/uikit/js/components/slideshow.js', //needed for the post galleries
                    'bower_components/uikit/js/components/slideshow-fx.js', //needed for the post galleries
                    'bower_components/uikit/js/components/upload.js', //needed for the gravity forms fileupload
                    'bower_components/uikit/js/components/notify.js', //needed for the budget list control
                    'js/compiled.js'
                    ]
                }
            }
        }
    });


    grunt.loadNpmTasks('grunt-babel');
    grunt.loadNpmTasks('grunt-exec');
    grunt.loadNpmTasks('grunt-bundles');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', [ 'babel', 'bundles', 'uglify', 'sass'] );
    grunt.registerTask('get_updates', [ 'exec:get_updates' ] );
};