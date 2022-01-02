<template>
	<jet-label for="city" required="true" value="City" />
    <jet-input id="city" type="text" class="mt-1 block" readonly />
    <jet-input-error :message="form.errors.city" class="mt-2" />
</template>