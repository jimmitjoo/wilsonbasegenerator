#! /usr/bin/env node

require('shelljs/global');

var clc = require('cli-color');
var prompt = require('prompt');

var arguments = process.argv.slice(2);
var command = arguments[0];

var root;


if (!which('wget')) {
    echo(clc.red('Sorry, this script requires wget'));
    echo('You can get it here: http://www.gnu.org/software/wget/');
    exit(1);
}

if (!which('bower')) {
    echo(clc.red('Sorry, this script requires bower'));
    echo('You can get it here: http://bower.io/');
    exit(1);
}

if (!which('gulp')) {
    echo(clc.red('Sorry, this script requires gulp'));
    echo('You can get it here: http://gulpjs.com/');
    exit(1);
}

if (!which('sed')) {
    echo(clc.red('Sorry, this script requires sed'));
    echo('You can get it here: http://gulpjs.com/');
    exit(1);
}


if (!command || command == '') {
    echo(clc.yellow('Please tell me what to do, I have no idea!'));
    echo(clc.blue('For example you can create a new installation of WordPress with Wilsons Base Theme.'));
    echo(clc.blue('If so, just type this command: ') + clc.green('wilson new'));
}


if (command == 'new') {
    exec('pwd', function(err, stdout, stderr) {
        root = stdout.trim();
        installWordPress();
    });

}


function installWordPress() {

    echo(clc.blue('Downloading latest version of WordPress...'));

    if (exec('wget https://wordpress.org/latest.tar.gz').code !== 0) {
        echo(clc.red('Error: Downloading WordPress with wget failed'));
        exit(1);
    } else {
        unpackWordPress();
        installPlugin('Advanced Custom Fields', '4.4.3');
        installPlugin('Custom Post Type UI', '1.1.2');
        installPlugin('WP Password Generator', '2.8.1');
        installWilsonBaseTheme();
    }

}


function unpackWordPress() {

    echo(clc.blue('Packing up WordPress'));

    if (exec('tar xfz latest.tar.gz').code !== 0) {
        echo(clc.red('Error: Packing up WordPress with "tar xfz" failed'));
        exit(1);
    } else {
        removeUnecessaryWordPressFiles();
    }

}

function removeUnecessaryWordPressFiles() {

    echo(clc.blue('Removing unecessary files from WordPress'));

    moveFile( root + '/wordpress/*',  root + '/')
    removeFile( root + '/wordpress');
    removeFile( root + '/readme.html');
    removeFile( root + '/license.txt');
    removeFile( root + '/latest.tar.gz');

}

function unpackZip(filename) {

    echo(clc.blue('Unzipping ' + filename));

    if (exec('unzip -a ' + filename).code !== 0) {
        echo(clc.red('Error: Packing up ' + filename + ' with "unzip" failed'));
        exit(1);
    }

}

function removeFile(filename) {

    echo(clc.blue('Removing ' + filename));

    rm('-rf', filename);

}

function moveFile(from, to) {

    echo(clc.blue('Moving from:' + from + ' , to: ' + to ));

    cp('-R', from, to)

}

function installPlugin(plugin, version) {

    echo(clc.blue('Installing ' + plugin + ', version: ' + version));

    cd( root + '/wp-content/plugins/');

    var pluginUrlEnc = plugin.toLowerCase();
        pluginUrlEnc = pluginUrlEnc.replace(/ /g, '-');

    var pluginDownloaded = false;

    if (exec('wget https://downloads.wordpress.org/plugin/' + pluginUrlEnc + '.zip').code !== 0) {
        pluginUrlEnc = pluginUrlEnc + '.' + version;
    } else {
        pluginDownloaded = true;
    }

    if (!pluginDownloaded && exec('wget https://downloads.wordpress.org/plugin/' + pluginUrlEnc + '.zip').code !== 0) {
        echo(clc.red('Error: Downloading ' + plugin + ' with version number and wget failed'));
        exit(1);
    }

    unpackZip(pluginUrlEnc + '.zip');
    removeFile(pluginUrlEnc + '.zip');

    echo(clc.green('Successfully installed ' + plugin));

    cd( root + '/');

}

function installWilsonBaseTheme() {

    echo(clc.blue('Installing Wilson Base Theme'));

    moveFile( root + '/wilson-base-theme',  root + '/wp-content/themes/');
    echo(clc.green('Successfully installed Wilson Base Theme'));

    setUpConfigFile();

}

function setUpConfigFile() {

    var schema = {
        properties: {
            siteUrl: {
                description: 'Url to production site',
                required: true
            },
            dbName: {
                description: 'Production database name',
                required: true
            },
            dbUser: {
                description: 'Production database user',
                required: true
            },
            tblPrefix: {
                description: 'WordPress table prefix',
                required: true
            },
            multiSite: {
                description: 'Allowing multisites?',
                default: false,
                required: true
            },
            fileEdit: {
                description: 'Prevent users from editing files.',
                default: true,
                required: true
            },
            disableCron: {
                description: 'Disable cron?',
                default: false,
                required: true
            },
            devDbPassword: {
                description: 'Dev database password?',
                hidden: true,
                required: true
            },
            stageDbPassword: {
                description: 'Stage database password?',
                hidden: true,
                required: true
            },
            prodDbPassword: {
                description: 'Production database password?',
                hidden: true,
                required: true
            }
        }
    };


    prompt.start();

    prompt.get(schema, function (err, result) {
        if (err) { return onErr(err); }

        moveFile( root + '/wilson-base-theme/wp-config.php', root + '/' );

        exec("sed -i '.bak' 's/NEWSITEURL/" + result.siteUrl + "/g' " + root + "/wp-config.php");
        exec("sed -i '.bak' 's/NEWSITEDATABASENAME/" + result.dbName + "/g' " + root + "/wp-config.php");
        exec("sed -i '.bak' 's/NEWSITEDATABASEUSER/" + result.dbUser + "/g' " + root + "/wp-config.php");
        exec("sed -i '.bak' 's/NEWSITETABLEPREFIX/" + result.tblPrefix + "/g' " + root + "/wp-config.php");
        exec("sed -i '.bak' 's/NEWSITEALLOWMULTISITE/" + result.multiSite + "/g' " + root + "/wp-config.php");
        exec("sed -i '.bak' 's/NEWSITEDISALLOWFILEEDIT/" + result.fileEdit + "/g' " + root + "/wp-config.php");
        exec("sed -i '.bak' 's/NEWSITEDISABLECRON/" + result.disableCron + "/g' " + root + "/wp-config.php");
        exec("sed -i '.bak' 's/NEWSITEDEVDBPASS/" + result.devDbPassword + "/g' " + root + "/wp-config.php");
        exec("sed -i '.bak' 's/NEWSITESTAGEDBPASS/" + result.stageDbPassword + "/g' " + root + "/wp-config.php");
        exec("sed -i '.bak' 's/NEWSITEPRODDBPASS/" + result.prodDbPassword + "/g' " + root + "/wp-config.php");

        echo(clc.green('Config file successfully created!'));

        removeFile( root + '/wp-config.php.bak');

        installDependencies();

    });

    function onErr(err) {
        console.log(err);
        return 1;
    }


}


function installDependencies() {

    cd( root + '/wp-content/themes/wilson-base-theme');

    echo(clc.blue('Installing Bower dependencies'));
    exec('bower install');

    if (exec('npm install').code !== 0) {
        echo(clc.red('Error: We could not install NPM dependencies for you...'));
        exit(1);
    } else {
        echo(clc.green('Time to start developing! Cd into the theme and start ') + clc.yellow('$ gulp'));
    }

}