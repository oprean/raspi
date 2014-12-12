<?php
class BackgroundProcess
{
    private $command;
    private $pid;

    public function __construct($command)
    {
        $this->command = $command;
    }

    public function run($outputFile = '/dev/null')
    {
        $this->pid = shell_exec(sprintf(
            '%s > %s 2>&1 & echo $!',
            $this->command,
            $outputFile
        ));
		sleep(1);
    }

	public static function isStarted($grep) {
		$result = shell_exec('ps f -u www-data | grep '.$grep);
		echo count(preg_split("/\n/", $result));
		if(count(preg_split("/\n/", $result)) > 3) {
			return true;
        } else {
        	return false;
        }
	}

    public function isRunning()
    {
        try {
            $result = shell_exec(sprintf('ps %d', $this->pid));
            if(count(preg_split("/\n/", $result)) > 2) {
                return true;
            }
        } catch(Exception $e) {}

        return false;
    }

    public function getPid()
    {
        return $this->pid;
    }
}