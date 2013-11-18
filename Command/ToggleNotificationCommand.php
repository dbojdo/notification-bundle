<?php
namespace Webit\Bundle\NotificationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Webit\Bundle\NotificationBundle\Notification\Toggle\ToggleServiceInterface;

class ToggleNotificationCommand extends ContainerAwareCommand {
	
	/**
	 * 
	 * @var ToggleServiceInterface
	 */
	private $toggle;
	
	protected function configure() {
		parent::configure();
		
		$this->setName('webit:notification:toggle')
			->setDescription('Enable or disable notifications');
		
		$this->addArgument('enable',InputArgument::REQUIRED,'Enable or disable notifications');
		$this->addArgument('toggleTo',InputArgument::OPTIONAL,'Toggle "to" date');
	}
	
	protected function initialize(InputInterface $input, OutputInterface $output) {
		$this->toggle = $this->getContainer()->get('webit_notification.toggle_service');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {
		$enable = in_array($input->getArgument('enable'), array('1','true'));
		$toggleTo = $input->getArgument('toggleTo') ? \DateTime::createFromFormat('Y-m-d H:i:s', $input->getArgument('toggleTo')) : null;

		$this->toggle->toggleNotifications($enable, $toggleTo);
		if($toggleTo) {
			$output->writeln(sprintf('Notification has been <info>%s</info> until <info>%s</info>.',($enable ? 'enabled' : 'disabled'), $toggleTo->format('Y-m-d H:i:s')));
		} else {
			$output->writeln(sprintf('Notification has been <info>%s</info>.',($enable ? 'enabled' : 'disabled')));
		}		
	}
}
?>
