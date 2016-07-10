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

/**
 * @package mask
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
trait TcaAwareTrait
{
    use LanguageAwareTrait;

    /**
     * @var string
     */
    protected $languageFileIdentifier = 'locallang_db.xlf';

    /**
     * @var string
     */
    protected $languageFilePath = 'Resources/Private/Language/';

    /**
     * @var array
     */
    protected $maskConfiguration;

    /**
     * @var string
     */
    protected $table;

    /**
     * @param array $fields
     * @return array
     */
    protected function replaceFieldLabels(array $fields)
    {
        foreach ($fields as $field => &$configuration) {
            if (0 === strpos($configuration['label'], 'LLL:')) {
                continue;
            }
            if (!isset($configuration['label']) && empty($this->maskConfiguration[$this->table]['elements'])) {
                continue;
            }

            $label = $field;
            if (isset($configuration['label'])) {
                $label = $configuration['label'];
            } else {
                foreach ($this->maskConfiguration[$this->table]['elements'] as $element) {
                    if (!in_array($field, $element['columns'], true)) {
                        continue;
                    }

                    $index = array_search($field, $element['columns']);
                    if (isset($element['labels'][$index])) {
                        $label = $element['labels'][$index];
                        break;
                    }
                }
            }

            $this->addLabel(
                $this->languageFilePath . $this->languageFileIdentifier,
                $this->table . '.' . $field,
                $label
            );
            $configuration['label'] = 'LLL:EXT:mask/'
                . $this->languageFilePath . $this->languageFileIdentifier . ':' . $this->table . '.' . $field;
        }

        return $fields;
    }
}
