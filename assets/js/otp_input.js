function moveToNextInput(input, nextInputIndex) {
    if (input.value.length === 1) {
        const nextInput = document.getElementById('otp-${nextInputIndex}');
        if (nextInput) {
            nextInput.focus();
        }
    }
}