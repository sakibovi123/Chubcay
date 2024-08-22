import { useEffect, useState } from 'react';
import React from 'react';
import { Head, Link, usePage, useForm } from '@inertiajs/react';
import { ReactNotifications, Store } from 'react-notifications-component'


function RechargeModal({ show, onClose }) {
    if (!show) return null; // Do not render the modal if show is false

    const {data, setData, post, processing, errors, reset} = useForm({
        amount: '',
        cardNumber: '',
        month: '',
        year: '',
        cvv: ''
    })

    const handleInputChange = (field, value) => {
        if (field === 'amount') {
            if (/^\d*$/.test(value) && value <= 5000) {
                setData(field, value);
            }
        } else if (['cardNumber', 'month', 'year', 'cvv'].includes(field)) {
            if (/^\d*$/.test(value)) {
                setData(field, value);
            }
        }
    };

    const rechargeBalance = (e) => {
        e.preventDefault()

        post(route('auth.recharge'), {
            onSuccess: () => {
                onClose();
                Store.addNotification({
                    title: "Success",
                    message: "Balance updated!",
                    type: "success",
                    insert: "top",
                    container: 'top-right',
                    dismiss: {
                        duration: 2000
                    }
                })
            }
        })
    }


    return (
        <div className="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
            <form onSubmit={rechargeBalance} className="flex flex-col gap-4 bg-white p-4 rounded shadow-lg w-1/3">
                <h2 className="text-xl font-bold mb-4">Recharge</h2>

                {Object.keys(errors).length > 0 && (
                    <div className="bg-red-100 text-red-700 p-2 rounded mb-4">
                        <ul>
                            {Object.values(errors).map((error, index) => (
                                <li key={index}>{error}</li>
                            ))}
                        </ul>
                    </div>
                )}

                <label htmlFor="Recharge Amount">Enter Amount</label>

                <input onChange={(e) => handleInputChange('amount', e.target.value)}
                    type="text"
                    name="amount"
                    className="border-gray-200 rounded"
                />

                <label htmlFor="Recharge Amount">Enter Card Number</label>
                <input onChange={(e) => handleInputChange('cardNumber', e.target.value)}
                    maxLength={"16"}
                    type="text"
                    name="cardNumber"
                    className="border-gray-200 rounded"
                />

                <label htmlFor="Month">Enter Month</label>
                <input
                    onChange={(e) => handleInputChange('month', e.target.value)}
                    type="text"
                    name="month"
                    className="border-gray-200 rounded"
                    maxLength={"2"}
                />

                <label htmlFor="Year">Enter Year</label>
                <input 
                    onChange={(e) => handleInputChange('year', e.target.value)}
                    type="text"
                    name="year"
                    className="border-gray-200 rounded"
                    maxLength={"2"}
                />

                <label htmlFor="CVC">Enter Cvc</label>
                <input 
                    onChange={(e) => handleInputChange('cvv', e.target.value)}
                    type="text"
                    name="cvv"
                    className="border-gray-200 rounded"
                    maxLength={"3"}
                />
                {/* Add your form or content here */}

                <button type="submit" className="text-white p-1 rounded bg-green-500">
                    Recharge
                </button>

                <button onClick={onClose} className="text-white p-1 rounded bg-red-500">
                    Close
                </button>
            </form>
        </div>
    );
}

export default RechargeModal;
