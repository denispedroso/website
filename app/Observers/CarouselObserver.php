<?php

namespace App\Observers;

use App\Carousel;

class CarouselObserver
{
    /**
     * Handle the carousel "created" event.
     *
     * @param  \App\Carousel  $carousel
     * @return void
     */
    public function saving(Carousel $carousel)
    {
        if ( Carousel::count() > 2) {
            return false;
        }
        return true;
    }

    /**
     * Handle the carousel "updated" event.
     *
     * @param  \App\Carousel  $carousel
     * @return void
     */
    public function updated(Carousel $carousel)
    {
        //
    }

    /**
     * Handle the carousel "deleted" event.
     *
     * @param  \App\Carousel  $carousel
     * @return void
     */
    public function deleted(Carousel $carousel)
    {
        //
    }

    /**
     * Handle the carousel "restored" event.
     *
     * @param  \App\Carousel  $carousel
     * @return void
     */
    public function restored(Carousel $carousel)
    {
        //
    }

    /**
     * Handle the carousel "force deleted" event.
     *
     * @param  \App\Carousel  $carousel
     * @return void
     */
    public function forceDeleted(Carousel $carousel)
    {
        //
    }
}
