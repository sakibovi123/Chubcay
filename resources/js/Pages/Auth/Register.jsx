import { useEffect, useRef, useState } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import WebCam from 'react-webcam';
import Webcam from 'react-webcam';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        country: '',
        city: '',
        password: '',
        password_confirmation: '',
        image: '',
        card_number: '',
        month: '',
        year: '',
        cvv: '',
    });

    // function capturing selfie
    const webcamRef = useRef(null);
    const [ image, setImage ] = useState('');
    const [ captured, setCaptured ] = useState(false);

    const capture = () => {
        const imageSrc = webcamRef.current.getScreenshot();
        setImage(imageSrc);
        // setData('image', imageSrc);

        if(captured === false) {
            setCaptured(true);
            setData('image', imageSrc);
        }
        
    };

    const recapture = () => {
        setCaptured(false);
    }

    const confirmImage = () => {
        // capture()?
    }

    const handleCardNumberChange = (e) => {
        let value = e.target.value.replace(/\s+/g, ''); // Remove any existing spaces
        value = value.replace(/[^0-9]/g, ''); // Remove non-numeric characters

        if (value.length > 16) {
            value = value.slice(0, 16); // Limit the input to 16 digits
        }

        // Add a space after every 4 digits
        const formattedValue = value.match(/.{1,4}/g)?.join(' ') || '';

        setData({ ...data, card_number: formattedValue });
    };

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(route('register'));
    };

    const handlePhone = (e) => {
        const value = e.target.value;
        const numericValue = value.replace(/[^0-9+()\s-]/g, '');
        setData('phone', numericValue);

    }

    return (
        <GuestLayout>
            <Head title="Register" />

            <form onSubmit={submit}>
                <div>
                    <InputLabel
                        htmlFor="selfie"
                        value="Upload Profile Image"
                        className="font-bold"
                    />
                    {/* webcam section */}
                    {
                        captured == false ? (
                            <div>
                                <WebCam
                                    className='w-full'
                                    audio={false}
                                    ref={webcamRef}
                                    screenshotFormat='image/jpeg'
                                    width={320}
                                    height={240}
                                />

                                <button type="button" onClick={capture} className="cursor-pointer bg-blue-700 p-1 font-bold rounded text-white mt-2">
                                    Capture Selfie
                                </button>
                            </div>
                            
                        ):(
                            <div>
                                {image && (
                                    <div>
                                        <h2>Preview:</h2>
                                        <img src={image} alt="Selfie Preview" className="mt-2" />
                                        <input type="hidden"
                                            name="image"
                                            value={image}
                                            onChange={(e) => setData('image', e.target.value)}
                                        />
                                        <InputError message={errors.image} className="mt-2" />
                                    </div>
                                )}
                                {/* <button onClick={confirmImage}
                                 className="cursor-pointer p-2 bg-green-500 rounded">Upload</button> */}
                                <button type="button" onClick={recapture}
                                    className="cursor-pointer mx-3 p-2 rounded bg-orange-300 m-2">
                                        Recapture
                                </button>
                                {/* <img src={image} alt="" /> */}
                            </div>

                        )
                    }
                    

                    
 
                    
                    {/* <input type="text" defaultValue={imageSrc} /> */}
                    <InputLabel htmlFor="name" value="First Name" />

                    <TextInput
                        id="first_name"
                        name="first_name"
                        value={data.first_name}
                        className="mt-1 block w-full"
                        autoComplete="name"
                        isFocused={true}
                        onChange={(e) => setData('first_name', e.target.value)}
                        required
                        maxLength={10}
                    />

                    <InputError message={errors.first_name} className="mt-2" />
                </div>

                <div>
                    <InputLabel htmlFor="name" value="Last Name" />

                    <TextInput
                        id="last_name"
                        name="last_name"
                        value={data.last_name}
                        className="mt-1 block w-full"
                        autoComplete="last_name"
                        isFocused={true}
                        onChange={(e) => setData('last_name', e.target.value)}
                        required
                    />

                    <InputError message={errors.name} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        onChange={(e) => setData('email', e.target.value)}
                        required
                        // maxLength={12}
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="phone" value="Phone" />

                    <TextInput
                        id="phone"
                        type="text"
                        name="phone"
                        value={data.phone}
                        className="mt-1 block w-full"
                        autoComplete="phone"
                        // onChange={(e) => setData('phone', e.target.value)}
                        onChange={(e) => handlePhone(e)}
                        required
                        // maxLength={12}
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="country" value="Country" />

                    <TextInput
                        id="country"
                        type="text"
                        name="country"
                        value={data.country}
                        className="mt-1 block w-full"
                        autoComplete="country"
                        onChange={(e) => setData('country', e.target.value)}
                        required
                    />

                    <InputError message={errors.company} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="city" value="City" />

                    <TextInput
                        id="city"
                        type="text"
                        name="city"
                        value={data.city}
                        className="mt-1 block w-full"
                        autoComplete="city"
                        onChange={(e) => setData('city', e.target.value)}
                        required
                    />

                    <InputError message={errors.company} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData('password', e.target.value)}
                        required
                    />

                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password_confirmation" value="Confirm Password" />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData('password_confirmation', e.target.value)}
                        required
                    />

                    <InputError message={errors.password_confirmation} className="mt-2" />
                </div>

                {/* payment infos */}
                <div className="mt-4">
                    <InputLabel htmlFor="cardNumber" value="Card Number" />

                    <TextInput
                        id="card_number"
                        type="text"
                        name="card_number"
                        value={data.card_number}
                        className="mt-1 block w-full"
                        autoComplete="card_number"
                        // onChange={(e) => setData('card_number', e.target.value)}
                        onChange={handleCardNumberChange}
                        maxLength="20"
                        required
                    />

                    <InputError message={errors.card_number} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="month" value="Month" />
                    <TextInput
                        id="month"
                        type="text"
                        name="month"
                        value={data.month}
                        className="mt-1 block w-full"
                        autoComplete="month"
                        onChange={(e) => setData('month', e.target.value)}
                        required
                        maxLength="2"
                    />
                    <InputError message={errors.month} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="year" value="Year" />
                    <TextInput
                        id="year"
                        type="text"
                        name="year"
                        value={data.year}
                        className="mt-1 block w-full"
                        autoComplete="year"
                        onChange={(e) => setData('year', e.target.value)}
                        required
                        maxLength="2"
                    />
                    <InputError message={errors.month} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="cvv" value="Cvv" />
                    <TextInput
                        id="cvv"
                        type="text"
                        name="cvv"
                        value={data.cvv}
                        className="mt-1 block w-full"
                        autoComplete="cvv"
                        onChange={(e) => setData('cvv', e.target.value)}
                        required
                        maxLength="3"
                    />
                    <InputError message={errors.month} className="mt-2" />
                </div>

                <div className="flex items-center justify-end mt-4">
                    <Link
                        href={route('login')}
                        className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Already registered?
                    </Link>

                    <PrimaryButton className="ms-4" disabled={processing}>
                        Register & Pay $50.00
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
