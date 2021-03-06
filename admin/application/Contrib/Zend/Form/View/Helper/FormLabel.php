<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Form
 * @subpackage View
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

namespace Zend\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\Exception;

/**
 * @category   Zend
 * @package    Zend_Form
 * @subpackage View
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class FormLabel extends AbstractHelper
{
    const APPEND  = 'append';
    const PREPEND = 'prepend';

    /**
     * Attributes valid for the label tag
     *
     * @var array
     */
    protected $validTagAttributes = array(
        'for'  => true,
        'form' => true,
    );

    /**
     * Generate an opening label tag
     * 
     * @param  null|array|ElementInterface $attributesOrElement 
     * @return string
     */
    public function openTag($attributesOrElement = null)
    {
        if (null === $attributesOrElement) {
            return '<label>';
        }

        if (is_array($attributesOrElement)) {
            $attributes = $this->createAttributesString($attributesOrElement);
            return sprintf('<label %s>', $attributes);
        }

        if (!$attributesOrElement instanceof ElementInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array or Zend\Form\ElementInterface instance; received "%s"',
                __METHOD__,
                (is_object($attributesOrElement) ? get_class($attributesOrElement) : gettype($attributesOrElement))
            ));
        }

        $id = $this->getId($attributesOrElement);
        if (null === $id) {
            throw new Exception\DomainException(sprintf(
                '%s expects the Element provided to have either a name or an id present; neither found',
                __METHOD__
            ));
        }

        $attributes = array('for' => $id);
        $attributes = $this->createAttributesString($attributes);
        return sprintf('<label %s>', $attributes);
    }

    /**
     * Return a closing label tag
     * 
     * @return string
     */
    public function closeTag()
    {
        return '</label>';
    }

    /**
     * Generate a form label, optionally with content
     *
     * Always generates a "for" statement, as we cannot assume the form input
     * will be provided in the $labelContent.
     * 
     * @param  ElementInterface $element 
     * @param  null|string $labelContent 
     * @param  string $position 
     * @return string
     */
    public function __invoke(ElementInterface $element, $labelContent = null, $position = null)
    {
        $openTag = $this->openTag($element);
        $label   = false;
        if (null === $labelContent || null !== $position) {
            $label = $element->getAttribute('label');
            if (null === $label) {
                throw new Exception\DomainException(sprintf(
                    '%s expects either label content as the second argument, or that the element provided has a label attribute; neither found',
                    __METHOD__
                ));
            }
        }

        if ($label && $labelContent) {
            switch ($position) {
                case self::APPEND:
                    $labelContent .= $label;
                    break;
                case self::PREPEND:
                default:
                    $labelContent = $label . $labelContent;
                    break;
            }
        }

        if ($label && null === $labelContent) {
            $labelContent = $label;
        }

        return $openTag . $labelContent . $this->closeTag();
    }
}
