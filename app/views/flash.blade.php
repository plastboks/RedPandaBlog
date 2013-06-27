<div id="flashmessage">
  @if ($flashStatus)
    <p class="status">{{ $flashStatus }}</p>
  @endif
  @if ($flashError)
    <p class="error">{{ $flashError }}</p>
  @endif
  @if ($flashSuccess)
    <p class="success">{{ $flashSuccess }}</p>
  @endif
</div>
