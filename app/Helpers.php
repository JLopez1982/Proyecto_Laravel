<?php

if (! function_exists('cart')) {
    function cart() {
      return app('cart');//retorna la clase cart
    }
  }