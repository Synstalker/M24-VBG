module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        babel: {
            options: {
                sourceMap: false,
                presets: ['es2015']
            },
            dist: {
                files: {
                    'TF_GF_Field_Email_Addons.js': 'TF_GF_Field_Email_Addons.jsx'
                }
            }
        },
        uglify:{
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
                compress: true
            },
            build: {
                src: ['TF_GF_Field_Email_Addons.js'],
                dest: 'TF_GF_Field_Email_Addons.min.js'
            }
        },
        watch:{
            js:{
                files:['TF_GF_Field_Email_Addons.jsx'],
                tasks:[ 'default' ]
            }
        }
    });


    grunt.loadNpmTasks('grunt-babel');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.registerTask('default', [ 'babel', 'uglify'] );
};