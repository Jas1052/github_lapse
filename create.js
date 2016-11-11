var exec = require('child_process').exec;
var cmd = 'php FileCommitAnimator/create.php';

console.log("Started");
exec(cmd, function (error, stdout, stderr) {
    // command output is in stdout
    console.log(stdout);
});

