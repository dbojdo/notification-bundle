<?php
namespace Webit\Bundle\NotificationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Webit\Bundle\NotificationBundle\Notification\Toggle\ToggleServiceInterface;

class ToggleStatusCommand extends ContainerAwareCommand {
	
	/**
	 * 
	 * @var ToggleServiceInterface
	 */
	private $toggle;
	
	protected function configure() {
		parent::configure();
		
		$this->setName('webit:notification:toggle-status')
			->setDescription('Checks notifications\' status');
	}
	
	protected function initialize(InputInterface $input, OutputInterface $output) {
		$this->toggle = $this->getContainer()->get('webit_notification.toggle_service');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {
		$enable = $this->toggle->isEnabled();
		
		$notificationStatus = $this->toggle->getLock()->getNotificationStatus();
		$toggleTo = $this->toggle->getLock()->getToggleDate();
		
		if($toggleTo) {
			if($enable != $notificationStatus) {
				$output->writeln(sprintf('Notification are <info>%s</info> (<info>%s</info> until <info>%s</info>)',($enable ? 'enabled' : 'disabled'),($notificationStatus ? 'enabled' : 'disabled'),$toggleTo->format('Y-m-d H:i:s')));
			} else {
				$output->writeln(sprintf('Notification are <info>%s</info> until <info>%s</info>',($enable ? 'enabled' : 'disabled'),$toggleTo->format('Y-m-d H:i:s')));
			}
		} else {
			$output->writeln(sprintf('Notification are <info>%s</info>',($enable ? 'enabled' : 'disabled')));
		}
		
	}
}
