const en = {
    words: {

        save: 'Save',
        saved: 'Saved',
        enable: 'Enable',
        confirm: 'Confirm',
        done: 'Done',
        optional: 'Optional',
        status: 'Status',

        // Contractor
        contractor: 'Contractor',

        // Worker
        worker: 'Worker',

        // Work
        work: 'Work',
        works: 'Works',
        newWork: 'New work',
        hiredWork: 'Hired work',
        myWorks: 'My works',
        workSpecialties: 'Work specialties',
        reference: 'Reference',
        scheduleWork: 'Schedule the work',
        select: 'Select...',

        // Certifications
        certification: 'Certification',
        certifications: 'Certifications',
        myCertifications: 'My certifications',
        newCertificate: 'New certificate',

        // Specialties
        specialty: 'Specialty',
        specialties: 'Specialties',
        mySpecialties: 'My specialties',

        // HiredWorks
        hiredWork: 'Hired work',
        hiredWorks: 'Hired works',
        schedule: 'Schedule',
        hire : 'Hire',
        estimatedTime: 'Estimated time',
        initiate: 'Initiate',

        // Appintments
        appointment: 'Appointment',
        appointments: 'Appointments',

        // Labels
        name: 'Name',
        description: 'Description',
        slug: 'Slug',
        time: 'Time',
        price: 'Price',
        action: 'Action',
        delete: 'Delete',
        remove: 'Remove',
        cancel: 'Cancel',
        add: 'Add',
        addMore: 'Add more',
        cnpj: 'CNPJ',
        cpf: 'ID',
        phoneNumbers: 'Phone numbers',

        // Unities
        unity: 'Unity',
        unities: 'Unities',

        // Auth
        manageAccount: 'Manage account',
        profile: 'Profile',
        register: 'Register',
        login: 'Login',
        logout: 'Logout',
        lowerCaseOr: 'or',
        email: 'E-mail',
        password: 'Password',
        fullName: 'Full name',
        confirmPassword: 'Confirm password',
        resetPassword: 'Reset password',
        new: 'New',
        close: 'Close',
        maxChars: 'Max characters',
        certifiedCredential: 'Certified credential',
        certifiedLink: 'Certified link',
        certificationName: 'Certification name',
        certificationIdentificator: 'Certification name',
        userSettings: 'User settings',
        update: 'Update',

        //Profile Information
        profileInformation: 'Informação do Perfil',

        //Update Password
        updatePassword:'Update Password',
        currentPassword: 'Current Password',
        newPassword: 'New Password',

        //Two Factor Authentication
        twoFactorAuthentication: 'Two Factor Authentication',
        setupKey: 'Setup Key',
        code: 'Code',

        //Browser Sessions
        browserSessions: 'Browser Sessions',
        thisDevice: 'This device',

        workerProfile: 'Worker profile',
        updateCnpjForm: 'Update CNPJ form',
        updatePhonesForm: 'Update Phones form',

        contractorProfile: 'Contractor profile',
        updateCpfForm: 'Update CPF form',

    },
    phrases: {
        mostHiredWorks: 'Most hired works',

        moreDetails: 'More details',
        noDescription: 'No description',

        moreDetails: 'More details',
        noDescription: 'No description',

        //Works
        scheduleWork: 'Need to schedule this work?',

         // HiredWorks
         notInitiated: 'Not initiated',
         initiated: 'Initiated at:',
         done: 'Done at:',
         progress: 'In progress',

        //Profile Information
        updateInformation: 'Update your accounts profile information and email address.',
        unverifiedEmail: 'Your email address is unverified.',
        clickHereEmail: 'Click here to re-send the verification email.',
        newVerificationLink: 'A new verification link has been sent to your email address.',

        //Update Password
        ensureYourAccount: 'Ensure your account is using a long, random password to stay secure.',

        //Two Factor Authentication
        addAdditionalSecurity: 'Add additional security to your account using two factor authentication.',
        factorAuthentication: 'You have not enabled two factor authentication.',
        finishEnablingAuthentication: 'Finish enabling two factor authentication.',
        whenTwoFactorAuthentication: 'When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phones Google Authenticator application.',
        toFinishEnabling: 'To finish enabling two factor authentication, scan the following QR code using your phones authenticator application or enter the setup key and provide the generated OTP code.',
        twoFactorAuthenticationIsNowEnabled: 'Two factor authentication is now enabled. Scan the following QR code using your phones authenticator application or enter the setup key.',
        storeTheseRecoveryCodes: 'Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.',
        regenerateRecoveryCodes: 'Regenerate Recovery Codes',
        showRecoveryCodes: 'Show Recovery Codes',
        confirmYourpassword: 'For your security, please confirm your password to continue.',

        //Browser Sessions
        manageSessions: 'Manage and log out your active sessions on other browsers and devices.',
        ifNecessary: 'If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.',
        lastActive: 'Last active',
        logOutOtherBrowserSessions: 'Log Out Other Browser Sessions',
        pleaseEnteryourPassword: 'Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.',

        // Worker Profile
        cnpjUpdated: 'CNPJ was updated successfully',
        phonesUpdated: 'Phone numbers was updated successfully',

        // Contractor Profile
        cpfUpdated: 'CPF was updated successfully',
    },
    messages: {
        priceMeasurement: 'for price measurement',
        work: {
            delete: {
                success: 'Work removed successfully',
            },
            store: {
                success: 'Work created successfully',
            },
        },
        certification: {
            delete: {
                success: 'Certification removed successfully',
            },
        },
        specialty: {
            store: {
                success: 'Specialty added successfully',
            },
            delete: {
                success: 'Specialty removed successfully',
            },
        },
        hiredWork: {
            errorDate: 'The scheduled to must be a date after now.',
            delete: {
                success: 'Hired work removed successfully',
            },
        },
        rememberMe: 'Remember me',
        forgotPassword: 'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.',
    },
    questions: {
        account: {
            alreadyHave: 'Already have an account?',
            doesntHave: 'Doesn\'t have an account?',
        },
        password: {
            forgot: 'Forgot your password?',
            reset: 'Email password reset link',
        },
        work: {
            hasUnity: 'Work has unity type?',
        },
    },
};

export default en;
