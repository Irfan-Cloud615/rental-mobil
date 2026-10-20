/**
 *  Register Multi-Step Wizard (bs-stepper + native per-step validation)
 *  Design mengikuti template auth-register-multisteps
 */

'use strict';

(function () {
  const stepperEl = document.querySelector('#multiStepsValidation');
  if (!stepperEl) {
    return;
  }

  const form = stepperEl.querySelector('#multiStepsForm');
  if (!form) {
    return;
  }

  const stepper = new Stepper(stepperEl, { linear: true });

  // Field per step (index sesuai urutan step bs-stepper)
  const fieldsByStep = [
    ['email', 'password', 'password_confirmation'], // Step 1: Akun
    ['name', 'phone', 'address'], // Step 2: Data Diri
    ['terms'] // Step 3: Konfirmasi
  ];

  const validators = {
    email: value => {
      if (!value.trim()) return 'Email wajib diisi.';
      if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(value)) return 'Masukkan alamat email yang valid.';
      return '';
    },
    password: value => {
      if (!value.trim()) return 'Password wajib diisi.';
      if (value.length < 8) return 'Password minimal 8 karakter.';
      return '';
    },
    password_confirmation: value => {
      const pass = form.querySelector('[name="password"]');
      if (!value.trim()) return 'Konfirmasi password wajib diisi.';
      if (pass && value !== pass.value) return 'Konfirmasi password tidak sama dengan password.';
      return '';
    },
    name: value => (!value.trim() ? 'Nama lengkap wajib diisi.' : ''),
    phone: value => (!value.trim() ? 'No. HP wajib diisi.' : ''),
    address: value => (!value.trim() ? 'Alamat wajib diisi.' : '')
  };

  // Kolom pembungkus field pada layout row/col template
  function fieldColumn(input) {
    return input.closest('.col-md-12, .col-sm-6, .col-6, .col-12') || input.closest('.content');
  }

  function showError(input, message) {
    input.classList.add('is-invalid');
    const column = fieldColumn(input);
    let feedback = column.querySelector('.invalid-feedback');
    if (!feedback) {
      feedback = document.createElement('div');
      feedback.className = 'invalid-feedback d-block';
      // Letakkan pesan di luar input-group agar terlihat
      const group = input.closest('.input-group') || input.closest('.form-check') || input;
      group.insertAdjacentElement('afterend', feedback);
    }
    feedback.textContent = message;
  }

  function clearError(input) {
    input.classList.remove('is-invalid');
    const column = fieldColumn(input);
    const feedback = column.querySelector('.invalid-feedback');
    if (feedback) {
      feedback.remove();
    }
  }

  function validateInput(name) {
    const input = form.querySelector('[name="' + name + '"]');
    if (!input) {
      return true;
    }

    if (input.type === 'checkbox') {
      if (!input.checked) {
        showError(input, 'Anda harus menyetujui ketentuan untuk melanjutkan.');
        return false;
      }
      clearError(input);
      return true;
    }

    const validate = validators[name];
    const message = validate ? validate(input.value) : (!input.value.trim() ? 'Kolom ini wajib diisi.' : '');
    if (message) {
      showError(input, message);
      return false;
    }
    clearError(input);
    return true;
  }

  function validateStep(index) {
    return (fieldsByStep[index] || []).map(validateInput).every(Boolean);
  }

  function updateReview() {
    const map = {
      reviewName: 'name',
      reviewEmail: 'email',
      reviewPhone: 'phone',
      reviewAddress: 'address'
    };
    Object.keys(map).forEach(key => {
      const node = document.getElementById(key);
      const src = form.querySelector('[name="' + map[key] + '"]');
      if (node && src) {
        node.textContent = src.value.trim() || '-';
      }
    });
  }

  // Tombol Lanjut / Kembali
  stepperEl.querySelectorAll('.btn-next').forEach(btn => {
    btn.addEventListener('click', () => {
      if (validateStep(stepper._currentIndex)) {
        stepper.next();
      }
    });
  });
  stepperEl.querySelectorAll('.btn-prev').forEach(btn => {
    btn.addEventListener('click', () => {
      if (stepper._currentIndex > 0) {
        stepper.previous();
      }
    });
  });

  // Bersihkan pesan error begitu user mengetik, dan perbarui ringkasan secara live
  form.addEventListener('input', e => {
    if (e.target.name) {
      clearError(e.target);
    }
    updateReview();
  });
  form.addEventListener('change', e => {
    if (e.target.name === 'terms') {
      clearError(e.target);
    }
    updateReview();
  });

  // Perbarui ringkasan saat memasuki (atau meninggalkan) sebuah step
  stepperEl.addEventListener('shown.bs-stepper', updateReview);

  // Validasi seluruh step sebelum submit (pastikan tidak ada step kosong)
  form.addEventListener('submit', e => {
    for (let i = 0; i < fieldsByStep.length; i++) {
      if (!validateStep(i)) {
        e.preventDefault();
        stepper.goTo(i);
        break;
      }
    }
  });

  updateReview();
})();
