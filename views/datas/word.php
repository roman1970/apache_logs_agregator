<?php if($word->audio_link) : ?>
<audio style="display: none" id="aud_play" autoplay>
    <source src="http://37.192.187.83:10080/<?=$word->audio_link?>" >
</audio>
<audio style="display: none" id="aud_play_phrase" >
    <source src="http://37.192.187.83:10080/<?=$word->audio_phrase_link?>" >
</audio>
<?php endif; ?>
<br>
<div id="deutsch_word" onclick="onPlay()" >
    <h1><?= $word->d_word ?> <i class="fa fa-volume-up" aria-hidden="true"></i></h1>
    <h4><?= $word->d_word_transcription ?></h4>
</div>
<div id="d_phrase" onclick="onPlayPhrase()">
    <h3><?= $word->d_phrase ?> <i class="fa fa-volume-up" aria-hidden="true"></i></h3>
    <h4><?= $word->d_phrase_transcription ?></h4>
</div>

<div id="translation" style="display: none">
    <h1><?= $word->d_word_translation ?></h1>
    <h4><?= $word->d_phrase_translation ?></h4>
</div>
<script>
    var word_id = <?= $word->id ?>;
  
</script>
