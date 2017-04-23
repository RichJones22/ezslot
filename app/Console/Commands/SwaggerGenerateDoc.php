<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Swagger\Annotations\Swagger;

class SwaggerGenerateDoc extends Command
{
    /**
     * Swagger executable
     */
    const SWAGGER_EXEC = 'vendor/bin/swagger';
    /**
     * Option flag
     */
    const SWAGGER_OPTION_FLAG = "-o";
    /**
     * Swagger JSON document location (relative)
     */
    const OUTPUT_PATH = 'public/docs';
    /**
     * Application directory
     */
    const SWAGGER_APP_DIR = "routes";
    /**
     * The name and signature of the console command
     * @var string
     */
    protected $signature = 'swagger:generate-docs';
    /**
     * The console command description.
     * @var string
     */
    protected $description;
    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->description = "Generates the Swagger JSON file; location is: " . '"' . self::OUTPUT_PATH . '"';
        parent::__construct();
    }
    /**
     * Execute the console command.
     * @return mixed
     * @throws Exception
     */
    public function handle()
    {
        // Are we in production? If so, we don't need to do this.
        if (app()->environment('production')) {
            $this->error("command is NOT to run in production");
        }
        // Create the docs location.
        $docsLocation = sprintf("%s/", base_path(self::OUTPUT_PATH));
        // If the directory doesn't exist, create it with standard 755 folder permissions.
        if (!is_dir($docsLocation)) {
            mkdir($docsLocation, 0755);
        }
        // Validate that the docs location is readable before proceeding.
        if (!is_writable($docsLocation)) {
            throw new Exception("Unable to write docs.");
        }
        // generate the Swagger JSON file
        shell_exec(sprintf("%s %s %s %s", self::SWAGGER_EXEC, self::SWAGGER_APP_DIR, self::SWAGGER_OPTION_FLAG, self::OUTPUT_PATH));
        return $this;
    }
}
