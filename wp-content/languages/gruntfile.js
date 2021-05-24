module.exports = function(grunt) {

    grunt.initConfig({
        copy: {
            main: {
                expand: true,
                src: ['./*.mo','./*.po', 'languages.php'],
                dest: 'themes/',
                rename: function(dest, src) {
                    console.log(dest);
                    console.log(src);
                    return dest + 'twentyfourdotcom-' + src.replace('./','');
                }
            },
        },
        copy_translation_files:{

        },
        watch: {
            scripts: {
                files: ['*.mo'],
                tasks: ['copy'],
                options: {
                    spawn: false,
                },
            },
        }
    });

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');


    grunt.registerTask('default', ['copy']);
    grunt.registerTask('watch', ['watch']);
};