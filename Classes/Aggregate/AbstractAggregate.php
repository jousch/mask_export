<?php
namespace CPSIT\MaskExport\Aggregate;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Nicole Cordes <typo3@cordes.co>, CPS-IT GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

abstract class AbstractAggregate
{
    /**
     * @var array
     */
    protected $maskConfiguration;

    /**
     * @var array
     */
    protected $systemTables = [
        'pages' => 'pages',
        'tt_content' => 'tt_content',
        'sys_file_reference' => 'sys_file_reference',
    ];

    /**
     * @param array $maskConfiguration
     */
    public function __construct(array $maskConfiguration)
    {
        $this->maskConfiguration = $maskConfiguration;
        $this->process();
    }

    /**
     * Evaluates the configuration and stores necessary Interface information
     */
    abstract protected function process();
}
