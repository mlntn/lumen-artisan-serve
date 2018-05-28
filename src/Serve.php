<?php

namespace Mlntn\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\ProcessUtils;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\PhpExecutableFinder;

class Serve extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'serve';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Serve the application on the PHP development server';

  /**
   * Execute the console command.
   *
   * @return void
   *
   * @throws \Exception
   */
  public function handle() {

    $host = $this->input->getOption('host');

    $port = $this->input->getOption('port');

    $base = ProcessUtils::escapeArgument(__DIR__);

    $binary = ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false));

    $docroot = $this->laravel->basePath() . '/public';

    $this->info("Lumen development server started on http://{$host}:{$port}/");

    if (defined('HHVM_VERSION')) {
      if (version_compare(HHVM_VERSION, '3.8.0') >= 0) {
        passthru("{$binary} -m server -v Server.Type=proxygen -v Server.SourceRoot={$base}/ -v Server.IncludeSearchPaths.docroot={$docroot} -v Server.IP={$host} -v Server.Port={$port} -v Server.DefaultDocument=server.php -v Server.ErrorDocument404=server.php");
      }
      else {
        throw new Exception("HHVM's built-in server requires HHVM >= 3.8.0.");
      }
    }
    else {
      passthru("{$binary} -S {$host}:{$port} -t '{$docroot}' {$base}/server.php");
    }
  }

  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions() {
    return [
      ['host', null, InputOption::VALUE_OPTIONAL, 'The host address to serve the application on.', 'localhost'],
      ['port', null, InputOption::VALUE_OPTIONAL, 'The port to serve the application on.', 8000],
    ];
  }

}
