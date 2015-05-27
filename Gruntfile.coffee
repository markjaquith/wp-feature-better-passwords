module.exports = (grunt) ->

	# Project configuration
	grunt.initConfig
		pkg: grunt.file.readJSON('package.json')

		wp_deploy:
			default:
				options:
					plugin_slug: '<%= pkg.name %>'
					build_dir: 'release/svn/'
					assets_dir: 'assets/'

		clean:
			release: [
				'release/<%= pkg.version %>/'
				'release/svn/'
			]
			svn_readme_md: [
				'release/svn/readme.md'
			]

		copy:
			main:
				src: [
					'**'
					'!node_modules/**'
					'!release/**'
					'!assets/**'
					'!.git/**'
					'!img/src/**'
					'!Gruntfile.*'
					'!package.json'
					'!.gitignore'
					'!.gitmodules'
					'!bin/**'
				]
				dest: 'release/<%= pkg.version %>/'
			svn:
				cwd: 'release/<%= pkg.version %>/'
				expand: yes
				src: '**'
				dest: 'release/svn/'

		replace:
			header:
				src: [ '<%= pkg.name %>.php' ]
				overwrite: yes
				replacements: [
					from: /^Version:(\s*?)[\w.-]+$/m
					to: 'Version: <%= pkg.version %>'
				]
			plugin:
				src: [ 'classes/plugin.php' ]
				overwrite: yes
				replacements: [
					from: /^(\s*?)const(\s+?)VERSION(\s*?)=(\s+?)'[^']+';/m
					to: "$1const$2VERSION$3=$4'<%= pkg.version %>';"
				,
					from: /^(\s*?)const(\s+?)CSS_JS_VERSION(\s*?)=(\s+?)'[^']+';/m
					to: "$1const$2CSS_JS_VERSION$3=$4'<%= pkg.version %>';"
				]
			svn_readme:
				src: [ 'release/svn/readme.md' ]
				dest: 'release/svn/readme.txt'
				replacements: [
					from: /^# (.*?)( #+)?$/mg
					to: '=== $1 ==='
				,
					from: /^## (.*?)( #+)?$/mg
					to: '== $1 =='
				,
					from: /^### (.*?)( #+)?$/mg
					to: '= $1 ='
				,
					from: /^Stable tag:\s*?[\w.-]+(\s*?)$/mi
					to: 'Stable tag: <%= pkg.version %>$1'
				]

		compress:
			default:
				options:
					mode: 'zip'
					archive: './release/<%= pkg.name %>.<%= pkg.version %>.zip'
				expand: yes
				cwd: 'release/<%= pkg.version %>/'
				src: [ '**/*' ]
				dest: '<%= pkg.name %>/'

	# Load other tasks
	grunt.loadNpmTasks 'grunt-contrib-concat'
	grunt.loadNpmTasks 'grunt-contrib-clean'
	grunt.loadNpmTasks 'grunt-contrib-copy'
	grunt.loadNpmTasks 'grunt-contrib-compress'
	grunt.loadNpmTasks 'grunt-text-replace'
	grunt.loadNpmTasks 'grunt-wp-deploy'

	# Default task
	grunt.registerTask 'default', [
		'replace:header'
		'replace:plugin'
	]

	# Build task
	grunt.registerTask 'build', [
		'default'
		'clean'
		'copy:main'
		'compress' # Can comment this out for WordPress.org plugins
	]

	# Prepare a WordPress.org release
	grunt.registerTask 'release:prepare', [
		'build'
		'copy:svn'
		'replace:svn_readme'
		'clean:svn_readme_md'
	]

	# Deploy out a WordPress.org release
	grunt.registerTask 'release:deploy', [
		'wp_deploy'
	]

	# WordPress.org release task
	grunt.registerTask 'release', [
		'release:prepare'
		'release:deploy'
	]

	grunt.util.linefeed = '\n'

