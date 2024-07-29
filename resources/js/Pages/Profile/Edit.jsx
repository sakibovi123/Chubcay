import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';
import { Head, Link, usePage, useForm } from '@inertiajs/react';
import Header from '@/Components/Main/Header';
import PricingCard from '@/Components/Main/PricingCard';
import InputError from '@/Components/InputError';
import QRCode from "react-qr-code";
import 'react-notifications-component/dist/theme.css'
import { ReactNotifications, Store } from 'react-notifications-component'






export default function Edit({user, existing_package}) {
    
    // const { existed_package } = usePage().props;

    const {data, setData, post, processing, errors, reset} = useForm({
        first_name: user.first_name || '',
        last_name: user.last_name || '',
        // email: '',
        phone: user.phone || '',
        country: user.country || '',
        city: user.city || '',
        current_password: '',
        new_password: '',
    });

    const handleChange = (e) => {
        setData(e.target.name, e.target.value);
    };

    const patchUser = (e) => {
        e.preventDefault()

        post(route('profile.update'), {
            onSuccess: Store.addNotification({
                title: "Success",
                message: "Profile updated!",
                type: "success",
                insert: "top",
                container: 'top-right',
                dismiss: {
                    duration: 2000
                }
            }),
            onError: (errors) => console.log(errors)
        })
    }

    const redirectToHome = () => {
        window.location.href = route('home.home') + "#pricing"

        // window.location.href = "#pricing"
        
    }

    return (
        // <AuthenticatedLayout
        //     user={auth.user}
        //     header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>}
        // >
        //     <Head title="Profile" />

        //     <div className="py-12">
        //         <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        //             <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        //                 <UpdateProfileInformationForm
        //                     mustVerifyEmail={mustVerifyEmail}
        //                     status={status}
        //                     className="max-w-xl"
        //                 />
        //             </div>

        //             <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        //                 <UpdatePasswordForm className="max-w-xl" />
        //             </div>

        //             <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        //                 <DeleteUserForm className="max-w-xl" />
        //             </div>
        //         </div>
        //     </div>
        // </AuthenticatedLayout>
        
        <div className="w-full container md:mx-auto">
            <Head title='Profile' />
            <ReactNotifications />
            <Header />

            <div className="w-full md:my-[1rem] p-3">
                <div className="md:flex items-start justify-between gap-5">
                    {
                        existing_package ? 
                        (
                            <div className="bg-white md:w-[30%] my-3 md:my-0 border rounded p-2">
                                <h2 className="p-2 font-extrabold">Active package: <span>{existing_package?.package.title}</span></h2>
                                <div className="p-2 text-start text-black font-extrabold">
                                    Expired in {existing_package?.duration} days
                                </div>

                                <div className="p-2 border">
                                    <QRCode
                                        value={existing_package?.token}
                                        style={{ textAlign: "center", width: "100%" }}
                                    />
                                    <button className="w-full bg-blue-600 p-2 rounded text-white font-bold my-3">
                                        Get QR on Email
                                    </button>
                                </div>
                                <div className="w-full flex justify-center gap-3">
                                    <button type="button" data-tooltip-target="tooltip-default" className="text-center w-[50%] bg-blue-600
                                        p-2 my-5 text-white font-extrabold rounded transition-all delay-5 hover:bg-blue-500"
                                    >
                                       Download Invoice
                                    </button>
                                    <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        Tooltip content
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <button className="text-center w-[50%] bg-blue-600
                                        p-2 my-5 text-white font-extrabold rounded transition-all delay-5 hover:bg-blue-500"
                                    >
                                        Sell Membership
                                    </button>
                                </div>
                                
                            </div>
                        ) :
                        (
                            <div className="bg-white md:w-[30%] my-3 md:my-0 border rounded p-2">
                                <h2 className="p-2 font-extrabold">No Active Package</h2>
                                <div className="p-2 text-start text-black font-extrabold">
                                    {/* Expired in {existing_package?.duration} days */}
                                </div>
                                <div className="w-full flex justify-center">
                                    <button onClick={redirectToHome} className="text-center w-[50%] bg-blue-600
                                        p-2 my-5 text-white font-extrabold rounded transition-all delay-5 hover:bg-blue-500"
                                    >
                                        Buy Membership Now
                                    </button>
                                </div>
                            
                            </div>
                        )
                    }
                    

                    <div className="p-2 md:w-[70%] bg-white border rounded">
                        <h1 className="text-2xl font-bold p-2">Profile</h1>
                        <form onSubmit={patchUser}
                             className="w-full p-2 flex flex-col items-start gap-3" action="">
                            <label htmlFor="Email">Email</label>
                            <input maxLength={16} type="email" disabled className="bg-red-200 w-full rounded border-gray-200"
                                defaultValue={user.email} />
                            <InputError message={errors.email} className="mt-2" />

                            <label htmlFor="FirstName">First Name</label>
                            <input maxLength={16} onChange={(e) => setData('first_name', e.target.value)}
                             type="text" className="w-full rounded border-gray-200"
                                value={data.first_name} />
                            <InputError message={errors.first_name} className="mt-2" />

                            <label htmlFor="LastEmail">Last Name</label>
                            <input maxLength={16} onChange={(e) => setData('last_name', e.target.value)}
                             type="text" className="w-full rounded border-gray-200"
                             value={data.last_name} />
                            <InputError message={errors.last_name} className="mt-2" />

                            <label htmlFor="Country">Country</label>
                            <input maxLength={16} onChange={(e) => setData('country', e.target.value)}
                                type="text" className="w-full rounded border-gray-200"
                                     value={data.country} />
                            <InputError message={errors.country} className="mt-2" />

                            <label htmlFor="Phone">Phone</label>
                            <input maxLength={16} onChange={(e) => setData('phone', e.target.value)}
                                 type="number" className="w-full rounded border-gray-200" value={data.phone} />
                            <InputError message={errors.phone} className="mt-2" />

                            <label htmlFor="City">City</label>
                            <input maxLength={16} onChange={(e) => setData('city', e.target.value)}
                                 type="text" className="w-full rounded border-gray-200" value={data.city} />
                            <InputError message={errors.city} className="mt-2" />

                            <label htmlFor="Current Password">Current Password</label>
                            <input onChange={handleChange} name="current_password"
                                 type="password" className="w-full rounded border-gray-200" placeholder="*********" />
                            <InputError message={errors.current_password} className="mt-2" />

                            <label htmlFor="New Password">New Password</label>
                            <input name="new_password" onChange={handleChange}
                                 type="password" className="w-full rounded border-gray-200" placeholder="*********" />
                            <InputError message={errors.new_passwoqrd} className="mt-2" />


                            <button type="submit"
                                 className="w-full text-center bg-blue-600 rounded
                                  shadow-md p-2 text-white font-bold transition-all delay-5 hover:bg-blue-700">
                                    Update Profile
                                </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    );
}
