<?php
interface PinRepository{
    public function savePin($pin);
    public function loadPin();
}