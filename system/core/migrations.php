<?php 

// ------------------------------------------------------------------------

/**
 * Migration Interface
 *
 * All migrations should implement this, forces up() and down() and gives
 * access to the CI super-global.
 *
 * @package		Migrations
 * @author		Phil Sturgeon
 */
abstract class Migration {

	public abstract function up();

	public abstract function down();

	function __get($var)
	{
		if (isset(Controller::getInstance()->$var))
		{
			return Controller::getInstance()->$var;
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Migrations Class
 *
 * Utility main controller.
 *
 * @package		Migrations
 * @author		Mat�as Montes
 */
class Migrations {

	private $_migrations_enabled = FALSE;
	private $_migrations_path = NULL;
	private $_migrations_version = 0;
	private static $instance;

	public $verbose = FALSE;
	public $error = NULL;

	static function getInstance()
	{
		if ( ! self::$instance)
		{
			self::$instance = new Migrations;
		}	
		return self::$instance;
	}

	function __construct($config = array())
	{
		if ( ! empty($config))
		{
			foreach ($config as $key => $val)
			{
				$this->{'_' . $key} = $val;
			}
		}

		$this->_migrations_path = RUTA_APP . '/migrations/';

		$db    = db::getInstance();
		$forge = Forge::getInstance();

		if ( ! $db->table_exists('schema_version'))
		{
			$forge->add_field(array(
				'version' => array('type' => 'INT', 'constraint' => 3),
			));

			$forge->create_table('schema_version', TRUE);

			$db->insert(array('version' => 0), 'schema_version');
		}
	}

	public function set_verbose($state)
	{
		$this->verbose = $state;
	}

	public function install()
	{
		$files = glob($this->_migrations_path . '*_*' . EXT);
		$file_count = count($files);

		for ($i = 0; $i < $file_count; $i++)
		{
			$name = basename($files[$i], EXT);
			if ( ! preg_match('/^\d{3}_(\w+)$/', $name))
			{
				$files[$i] = FALSE;
			}
		}

		$migrations = array_filter($files);

		if ( ! empty($migrations))
		{
			sort($migrations);
			$last_migration = basename(end($migrations));
			$last_version = substr($last_migration, 0, 3);
			return $this->version(intval($last_version, 10));
		}
		else
		{
			$this->error = 'There are no migrations.';
			return FALSE;
		}
	}

	function version($version)
	{
		$schema_version = $this->_get_schema_version();
		$start	= $schema_version;
		$stop	= $version;

		if ($version > $schema_version)
		{
			// Moving Up
			++$start;
			++$stop;
			$step = 1;
		}

		else
		{
			// Moving Down
			$step = -1;
		}

		$method = $step === 1 ? 'up' : 'down';
		$migrations = array();

		for ($i = $start; $i != $stop; $i += $step)
		{
			$f = glob(sprintf($this->_migrations_path . '%03d_*' . EXT, $i));

			if (count($f) > 1)
			{
				$this->error = 'There are multiple versions of the same migration '.$i;
				return FALSE;
			}

			if (count($f) == 0)
			{
				if ($migrations) break;

				$this->error = 'Migration not found '.$i;
				return FALSE;
			}

			$file = basename($f[0]);
			$name = basename($f[0], EXT);

			if (preg_match('/^\d{3}_(\w+)$/', $name, $match))
			{
				$match[1] = strtolower($match[1]);

				if (in_array($match[1], $migrations))
				{
					$this->error = 'There are multiple migrations with the same name '.$match[1];
					return FALSE;
				} 

				include $f[0];
				$class = 'Migration_' . ucfirst($match[1]);

				if ( ! class_exists($class))
				{
					$this->error = 'Class doesn\'t exists'.$class;
					return FALSE;
				}

				if ( ! is_callable(array($class, 'up')) || !is_callable(array($class, 'down')))
				{
					$this->error = 'Wrong Interface implementation on the migration class '.$class;
					return FALSE;
				}

				$migrations[] = $match[1];
			}
			else
			{
				$this->error = 'Invalid migrations filename '.$file;
				return FALSE;
			}
		}

		$version = $i + ($step == 1 ? -1 : 0);

		if ($migrations === array())
		{
			if ($this->verbose)
			{
				echo 'Schema up to date'.PHP_EOL;
			}

			return TRUE;
		}

		if ($this->verbose)
		{
			echo '<p>Current schema version: ' . $schema_version . '<br/>';
			echo 'Moving ' . $method . ' to version ' . $version . '</p>';
			echo '<hr/>';
		}

		foreach ($migrations as $migration)
		{
			if ($this->verbose)
			{
				echo $migration.':<br />';
				echo '<blockquote>';
			}

			$class = 'Migration_' . ucfirst($migration);
			call_user_func(array(new $class, $method));

			if ($this->verbose)
			{
				echo '<pre>'.db::getInstance()->last_query().'</pre>';
				echo '</blockquote>';
				echo '<hr/>';
			}

			$schema_version += $step;
			$this->_update_schema_version($schema_version);
		}

		if ($this->verbose)
		{
			echo '<p>All done. Schema is at version '.$schema_version.'.</p>';
		}

		return $schema_version;
	}

	public function latest()
	{
		$version = $this->_migrations_version;
		return $this->version($version);
	}

	private function _get_schema_version()
	{
		$row = db::getInstance()->get('schema_version')->row();
		return $row ? $row->version : 0;
	}

	private function _update_schema_version($schema_version)
	{
		return db::getInstance()->update(array('version' => $schema_version),'schema_version');
	}
}