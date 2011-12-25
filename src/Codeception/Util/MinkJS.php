<?php
namespace Codeception\Util;

class MinkJS extends Mink
{

    public function doubleClick($link) {
        $el = $this->findEl($link);
        $el->doubleClick();
    }

    public function clickWithRightButton($link) {
        $el = $this->findEl($link);
        $el->rightClick();

    }

    public function moveMouseOver($link) {
        $el = $this->findEl($link);
        $el->mouseOver();
    }

    public function focus($el) {
        $el = $this->findEl($el);
        $el->focus();
    }

    public function blur($el) {
        $el = $this->findEl($el);
        $el->blur();
    }

    public function dragAndDrop($el1, $el2) {
        $el1 = $this->findEl($el1);
        $el2 = $this->findEl($el2);
        $el1->dragTo($el2);
    }
    
    public function seeElement($css) {
        $el = $this->session->getPage()->find('css', $css);
        if (!$el) \PHPUnit_Framework_Assert::fail("Element $css not found");
        \PHPUnit_Framework_Assert::assertTrue($this->session->getDriver()->isVisible($el->getXPath()));
    }

    /**
     * We use 'see' command only on visible elements
     *
     * @param $text
     * @param null $selector
     * @return array
     */
    protected function proceedSee($text, $selector = null) {
        if (!$selector) parent::proceedSee($text, $selector);
        $nodes = $this->session->getPage()->findAll('css', $selector);
		$values = array();
		foreach ($nodes as $node) {
            if (!$this->session->getDriver()->isVisible($node->getXPath())) continue;
		    $values[] = trim($node->getText());
        }
		return array('contains', $text, $values, "'$selector' selector in " . $this->session->getPage()->getContent().'. For more details look for page snapshot in the log directory');
    }

    public function pressKey($element, $char, $modifier = null)
    {
        $el = $this->findEl($element);
        $this->session->getDriver()->keyPress($el->getXPath(), $char, $modifier);
    }
    
    public function pressKeyUp($element, $char, $modifier = null) {
        $el = $this->findEl($element);
        $this->session->getDriver()->keyUp($el->getXPath(), $char, $modifier);
    }

    public function pressKeyDown($element, $char, $modifier = null) {
        $el = $this->findEl($element);
        $this->session->getDriver()->keyDown($el->getXPath(), $char, $modifier);
    }

    public function wait($miliseconds) {
        $this->session->getDriver()->wait($miliseconds, null);
    }
    
    public function waitForJS($miliseconds, $jsCondition) {
        $this->session->getDriver()->wait($miliseconds, $jsCondition);
    }
    
    public function executeJs($jsCode) {
        $this->session->getDriver()->executeScript($jsCode);
    }

}