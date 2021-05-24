module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        sass:{
            dist:{
                options:{
                    sourcemap:'none',
                    style:'compressed'
                },
                files:{
                    'style.min.css' : 'style.scss'
                }
            },
            dev:{
                options:{
                    sourcemap:'none',
                    style:'expanded'
                },
                files:{
                    'style.css' : 'style.scss'
                }
            }
        },
        watch:{
            css:{
                files:'*.scss',
                tasks:['sass']
            }
        }
    })

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('compile-sass', ['sass']);
    grunt.registerTask('watch-sass', ['watch']);

    // Default task(s).
    grunt.registerTask('default', ['sass']);
};