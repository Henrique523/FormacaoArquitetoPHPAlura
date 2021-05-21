<?php

namespace Alura\Calisthenics\Domain\WatchedVideos;

use Alura\Calisthenics\Domain\Video\Video;
use DateTimeInterface;
use Ds\Map;

class WatchedVideos implements \Countable
{
  private Map $videos;

  public function add(Video $video, \DateTimeInterface $date): void
  {
    $this->videos->put($video, $date);
  }

  public function count(): int
  {
    return $this->videos->count();
  }

  public function dateOfFirstVideo(): DateTimeInterface
  {
    $this->watchedVideos
      ->sort(fn (DateTimeInterface $dateA, DateTimeInterface $dateB) => $dateA <=> $dateB);
    return $this->watchedVideos->first()->value;
  }
}
